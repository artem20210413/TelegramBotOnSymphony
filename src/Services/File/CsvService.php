<?php

namespace App\Services\File;

use App\Services\Report\ReportDto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class CsvService implements IFile
{
    public function __construct(public ReportDto $reportDto)
    {
    }


    public function getData(): string
    {
        $data = [
            ['countActiveUsers', 'percentageCorrectAnswers', 'percentageIncorrectAnswers', 'totalCountQuizzesStarted', 'totalCountUniqueUsers'], // Заголовки
            [$this->reportDto->getCountActiveUsers(), $this->reportDto->getPercentageCorrectAnswers(), $this->reportDto->getPercentageIncorrectAnswers(),
                $this->reportDto->getTotalCountQuizzesStarted(), $this->reportDto->getTotalCountUniqueUsers()],
        ];
        $serializedData = serialize($data);
        return $serializedData;
    }


}