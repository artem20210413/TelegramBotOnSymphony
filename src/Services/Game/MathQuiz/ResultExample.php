<?php


namespace App\Services\Game\MathQuiz;


class ResultExample
{

    private int $resultCorrect;
    private int $resultErroneous_1;
    private int $resultErroneous_2;

    public function __construct(public MathQuizExample $mathQuizExample)
    {
        $this->setResultCorrect()
            ->setResultErroneous1()
            ->setResultErroneous2();
    }

    /**
     * @param mixed $resultCorrect
     */
    private function setResultCorrect(): static
    {
        $this->resultCorrect = $this->mathQuizExample->getFirstNumber() * $this->mathQuizExample->getSecondNumber();

        return $this;
    }

    private function setResultErroneous1(): static
    {
        $this->resultErroneous_1 = ($this->mathQuizExample->getFirstNumber() - 1) * $this->mathQuizExample->getSecondNumber();

        return $this;
    }

    private function setResultErroneous2(): static
    {
        $this->resultErroneous_2 = $this->mathQuizExample->getFirstNumber() * ($this->mathQuizExample->getSecondNumber() - 1);

        return $this;
    }


    /**
     * @return mixed
     */
    public function getResultCorrect(): int
    {
        return $this->resultCorrect;
    }

    /**
     * @return mixed
     */
    public function getResultErroneous1(): int
    {
        return $this->resultErroneous_1;
    }


    /**
     * @return mixed
     */
    public function getResultErroneous2(): int
    {
        return $this->resultErroneous_2;
    }


}
