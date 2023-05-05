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
        $ff = $this->parameterBag->get('telegram');
        dd($ff);
    }

}