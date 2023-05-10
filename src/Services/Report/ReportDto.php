<?php

namespace App\Services\Report;

class ReportDto
{
    public function __construct()
    {
    }

    private int $countActiveUsers;
    private int $percentageCorrectAnswers;
    private int $percentageIncorrectAnswers;
    private int $totalCountQuizzesStarted;
    private int $totalCountUniqueUsers;

    /**
     * @return int
     */
    public function getCountActiveUsers(): int
    {
        return $this->countActiveUsers;
    }

    /**
     * @param int $countActiveUsers
     */
    public function setCountActiveUsers(int $countActiveUsers): void
    {
        $this->countActiveUsers = $countActiveUsers;
    }

    /**
     * @return int
     */
    public function getPercentageCorrectAnswers(): int
    {
        return $this->percentageCorrectAnswers;
    }

    /**
     * @param int $percentageCorrectAnswers
     */
    public function setPercentageCorrectAnswers(int $percentageCorrectAnswers): void
    {
        $this->percentageCorrectAnswers = $percentageCorrectAnswers;
    }

    /**
     * @return int
     */
    public function getPercentageIncorrectAnswers(): int
    {
        return $this->percentageIncorrectAnswers;
    }

    /**
     * @param int $percentageIncorrectAnswers
     */
    public function setPercentageIncorrectAnswers(int $percentageIncorrectAnswers): void
    {
        $this->percentageIncorrectAnswers = $percentageIncorrectAnswers;
    }

    /**
     * @return int
     */
    public function getTotalCountQuizzesStarted(): int
    {
        return $this->totalCountQuizzesStarted;
    }

    /**
     * @param int $totalCountQuizzesStarted
     */
    public function setTotalCountQuizzesStarted(int $totalCountQuizzesStarted): void
    {
        $this->totalCountQuizzesStarted = $totalCountQuizzesStarted;
    }


    /**
     * @return int
     */
    public function getTotalCountUniqueUsers(): int
    {
        return $this->totalCountUniqueUsers;
    }

    /**
     * @param int $totalCountUniqueUsers
     */
    public function setTotalCountUniqueUsers(int $totalCountUniqueUsers): void
    {
        $this->totalCountUniqueUsers = $totalCountUniqueUsers;
    }


}