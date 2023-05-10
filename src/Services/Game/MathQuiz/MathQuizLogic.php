<?php


namespace App\Services\Game\MathQuiz;


use App\Services\Telegram\Messages\MessageDto;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MathQuizLogic extends MathQuizExample
{

    public function __construct(public MessageDto $messageDto, ParameterBagInterface $parameterBag)
    {
        parent::__construct($parameterBag);
    }


    //узнать что пришло getScore или число(ответ)


    public function responseMessage(): string
    {
        $text = $this->messageDto->getText();
        if ($text === '/start') {

            return $this->start($this->messageDto);
        } elseif (is_numeric($text)) {

            return $this->calculationExample($this->messageDto);
        } else if ($text === '/getScore') {

            return $this->getScore($this->messageDto);
        } else {

            return 'Упс... Невідома команда.';
        }
    }




}
