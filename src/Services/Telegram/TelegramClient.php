<?php


namespace App\Services\Telegram;


use App\Services\Telegram\RequestParams\GetUpdateParams;
use App\Services\Telegram\RequestParams\IToArray;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;

class TelegramClient
{
    public function __construct(public ParameterBagInterface $parameterBag)
    {
    }

    protected function makeRequest(string $method, IToArray $params)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', $this->getBasicUrl() . $method, [
            'query' => $params->toArray(),
        ]);
        if ($response->getStatusCode() === 200) {
            $content = $response->getContent();
            $result = json_decode($content, true);
            // обработка результата
            return $this->getResult($result);
        } else {
            return $response->getContent();
        }
//        $response = Http::get($this->getBasicUrl() . $method . '?' . http_build_query($params->toArray()));
//
//        return $this->getResult($response->json());
    }

    private function getBasicUrl()
    {
        return 'https://' . $this->getDomain() . '/bot' . $this->getToken() . '/';
    }

    private function getDomain()
    {
        return $this->parameterBag->get('telegram')['TELEGRAM_DOMAIN'];//config('telegram.TELEGRAM_DOMAIN');
    }

    private function getToken()
    {
        return $this->parameterBag->get('telegram')['TELEGRAM_TOKEN']; //config('telegram.TELEGRAM_TOKEN');
    }

    protected function getResult(array $json)
    {
        $this->isOk($json);
        return $json['result'];
    }

    private function isOk(array $json): void
    {
        if (!isset($json['ok']) || $json['ok'] !== true || !isset($json['result'])) {
            throw new \Exception('Invalid response API telegram');
        }
    }
}
