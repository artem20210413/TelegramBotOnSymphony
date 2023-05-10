<?php

namespace App\Services\File;

use App\Services\Report\ReportDto;

interface IFile
{
    public function __construct(ReportDto $reportDto);

    public function getData();


}