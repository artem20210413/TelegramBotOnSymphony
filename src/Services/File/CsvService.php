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


    public function generateAndSaveCsvFile(SerializerInterface $serializer): Response
    {
        // Данные для записи в CSV-файл
        $data = [
            ['Заголовок 1', 'Заголовок 2', 'Заголовок 3'], // Заголовки
            ['Значение 1', 'Значение 2', 'Значение 3'], // Пример данных
            ['Значение 4', 'Значение 5', 'Значение 6'],
        ];

        // Преобразование данных в CSV-формат
        $csvData = $serializer->serialize($data, CsvEncoder::FORMAT, ['csv_delimiter' => ';']);

        // Возвращаем Response с заголовками для скачивания файла
        return new StreamedResponse(function () use ($csvData) {
            echo $csvData;
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="имя_файла.csv"',
        ]);
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