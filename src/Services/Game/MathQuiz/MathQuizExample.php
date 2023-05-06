<?php


namespace App\Services\Game\MathQuiz;


use App\Services\Telegram\MessageDto;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MathQuizExample
{

    private int $firstNumber;
    private int $secondNumber;
    private string $stringExample;

    private string $prefixCacheKey;
    private int $timeCache;
    private int $randomGenerationFrom;
    private int $randomGenerationBefore;
    private string $cacheNameActiveResult;
    private string $cacheNameScore;
    private int $addScoreOnSuccess;
    private int $addScoreOnFailure;
    private ResultExample $resultExample;
    private FilesystemAdapter $cache;

    public function __construct(public ParameterBagInterface $parameterBag)
    {
        $this->cache = new FilesystemAdapter();
        $this->pullWithPackage();

        $this->generationNumbers()
            ->setStringExample()
            ->setResultExample();

    }



    /**
     * @param int $firstNumber
     */
    private function generationNumbers(): static
    {
        $from = $this->getRandomGenerationFrom();
        $before = $this->getRandomGenerationBefore();
        $this->firstNumber = random_int($from, $before);
        $this->secondNumber = random_int($from, $before);

        return $this;
    }

    /**
     * @param string $example
     */
    private function setStringExample(): static
    {
        $this->stringExample = ((string)$this->getFirstNumber()) . '*' . ((string)$this->getSecondNumber());

        return $this;
    }

    /**
     * @param ResultExample $resultExample
     */
    private function setResultExample(): static
    {
        $this->resultExample = new ResultExample($this);

        return $this;
    }

    /**
     * @return int
     */
    public function getFirstNumber(): int
    {
        return $this->firstNumber;
    }

    /**
     * @return int
     */
    public function getSecondNumber(): int
    {
        return $this->secondNumber;
    }

    /**
     * @return string
     */
    public function getPrefixCacheKey(): string
    {
        return $this->prefixCacheKey;
    }

    /**
     * @return int
     */
    public function getTimeCache(): int
    {
        return $this->timeCache;
    }

    /**
     * @return int
     */
    public function getRandomGenerationFrom(): int
    {
        return $this->randomGenerationFrom;
    }

    /**
     * @return int
     */
    public function getRandomGenerationBefore(): int
    {
        return $this->randomGenerationBefore;
    }

    /**
     * @return string
     */
    public function getCacheNameActiveResult(): string
    {
        return $this->cacheNameActiveResult;
    }

    /**
     * @return string
     */
    public function getCacheNameScore(): string
    {
        return $this->cacheNameScore;
    }

    /**
     * @return int
     */
    public function getAddScoreOnSuccess(): int
    {
        return $this->addScoreOnSuccess;
    }

    /**
     * @return int
     */
    public function getAddScoreOnFailure(): int
    {
        return $this->addScoreOnFailure;
    }

    private function pullWithPackage(): void
    {
        $math = $this->parameterBag->get('games')['math'];

        $this->prefixCacheKey = $math['prefixCacheKey'];
        $this->timeCache =  $math['timeCache'];
        $this->randomGenerationFrom = $math['randomGenerationFrom'];
        $this->randomGenerationBefore = $math['randomGenerationBefore'];
        $this->cacheNameActiveResult = $math['cacheNameActiveResult'];
        $this->cacheNameScore = $math['cacheNameScore'];
        $this->addScoreOnSuccess = $math['addScoreOnSuccess'];
        $this->addScoreOnFailure = $math['addScoreOnFailure'];
    }

    /**
     * @return string
     */
    public function getStringExample(): string
    {
        return $this->stringExample;
    }

    /**
     * @return ResultExample
     */
    public function getResultExample(): ResultExample
    {
        return $this->resultExample;
    }


    protected function saveExampleToCache(int $user_id, int $activeResult, int $score): void
    {
        $time = $this->getTimeCache();
        $prefix = $this->getPrefixCacheKey();
        $key = $prefix . $user_id;
        $value = [
            $this->getCacheNameActiveResult() => $activeResult,
            $this->getCacheNameScore() => $score
        ];

        $item = $this->cache->getItem($key);
        $item->set($value);
        $item->expiresAfter($time);
        $this->cache->save($item);

//        $this->cache->set($key, $value, $time);
//        Cache::put($key, $value, $time);
    }

    protected function checkResultInCache(int $user_id, int $result): ?bool
    {
        $prefix = $this->getPrefixCacheKey();
        $key = $prefix . $user_id;
        $value = $this->cache->getItem($key)->get();//Cache::get($key);
        $cacheNameActiveResult = $this->getCacheNameActiveResult();

        return !$value ? null
            : $value[$cacheNameActiveResult] === $result;
    }

    protected function getScore(MessageDto $messageDto): string
    {
        $prefix = $this->getPrefixCacheKey();
        $userId = $messageDto->getUserDto()->getId();
        $name = $messageDto->getUserDto()->getFirstName();
        $timeMin = $this->getTimeCache() / 60;
        $key = $prefix . $userId;
        $value = $this->cache->getItem($key)->get();// Cache::get($key);
        $cacheNameScore = $this->getCacheNameScore();

        if (!$value) {
            return "$name у Вас немає зіграних ігор за останні $timeMin хвилин.";
        }

        $score = $value[$cacheNameScore];

        return "$name Ваш рахунок $score од.";
    }


    private function addNewExample(MessageDto $messageDto, ?int $score = null): string
    {
        $userId = $messageDto->getUserDto()->getId();
        $activeResult = $this->getResultExample()->getResultCorrect();
        $this->saveExampleToCache($userId, $activeResult, (int)$score);

        return $this->getStringExample();
    }

    protected function calculationExample(MessageDto $messageDto)
    {

        $prefixCacheKey = $this->getPrefixCacheKey();
        $userId = $messageDto->getUserDto()->getId();
        $requestNumber = $messageDto->getText();
        $key = $prefixCacheKey . $userId;
        $value = $this->cache->getItem($key)->get();// Cache::get($key);
        $cacheNameActiveResult = $this->getCacheNameActiveResult();
        $cacheNameScore = $this->getCacheNameScore();
        $score = $value[$cacheNameScore] ?? null;
        $activeResult = $value[$cacheNameActiveResult] ?? null;

        if ((int)$requestNumber === (int)$activeResult) {
            $prefixResponseMessage = 'Вірно! Ось нове завдання.';
            $addScoreOnSuccess = $this->getAddScoreOnSuccess();
            $newScore = (int)$score + (int)$addScoreOnSuccess;
            $example = $this->addNewExample($messageDto, $newScore);

        } else if ($activeResult && (((int)$requestNumber !== (int)$activeResult))) {
            $prefixResponseMessage = 'Не вірно! Ось нове завдання: ';
            $addScoreOnFailure = $this->getAddScoreOnFailure();
            $newScore = (int)$score + (int)$addScoreOnFailure;
            $newScore = $newScore < 0 ? 0 : $newScore;
            $example = $this->addNewExample($messageDto, $newScore);

        } else {
            $prefixResponseMessage = 'Привіт! Ось твоє завдання: ';
            $example = $this->addNewExample($messageDto);
        }

        return $prefixResponseMessage . $example;

    }

    protected function start(MessageDto $messageDto)
    {
        $prefixCacheKey = $this->getPrefixCacheKey();
        $userId = $messageDto->getUserDto()->getId();
        $key = $prefixCacheKey . $userId;
        $isForget = $this->cache->delete($key);// Cache::forget($key);
        $prefixResponseMessage = 'Привіт';

        if ($isForget) {
            $prefixResponseMessage = $prefixResponseMessage . ', старі результати віддалилися';
        }

        $prefixResponseMessage = $prefixResponseMessage . '! Ось твоє завдання: ';
        $example = $this->addNewExample($messageDto);

        return $prefixResponseMessage . $example;
    }

}
