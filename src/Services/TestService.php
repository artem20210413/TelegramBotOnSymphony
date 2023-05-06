<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TestService
{

    public function __construct(public ParameterBagInterface $parameterBag)
    {
    }

    public function test()
    {
//        dd($this->cache->get('telegram'), $this->cache->parameterBag->get('telegram'));
//        $ff = $this->parameterBag->get('telegram')['token'];
        dd($this->parameterBag->get('telegram')['TELEGRAM_DOMAIN'], $this->parameterBag->get('telegram')['TELEGRAM_TOKEN']);
    }

}