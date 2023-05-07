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

    protected function makeRequest(string $method, IToArray $params): array
    {
//        $response = Http::get($this->getBasicUrl() . $method . '?' . http_build_query($params->toArray()));
        $client = HttpClient::create();
        $url = $this->getBasicUrl() . $method . '?' . http_build_query($params->toArray());
        $response = $client->request('GET', $url);

        if ($response->getStatusCode() === 200) {
            $content = json_decode($response->getContent(), true);

            return $content['result'];
        } else {

            return [];
        }
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

    protected function getResult($json)
    {
        dd();
        return $json['result'];
    }

    private function isOk(array $json): void
    {
        if (!isset($json['ok']) || $json['ok'] !== true || !isset($json['result'])) {
            throw new \Exception('Invalid response API telegram');
        }
    }
}
