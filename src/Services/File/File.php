<?php

namespace App\Services\File;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class File
{

    public function download($data, SerializerInterface $serializer): Response
    {

        $csvData = $serializer->serialize($data, CsvEncoder::FORMAT, ['csv_delimiter' => ';']);

        return new StreamedResponse(function () use ($csvData) {
            echo $csvData;
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="имя_файла.csv"',
        ]);
    }
}