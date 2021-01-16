<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Http\Validation\FileValidator;
use App\Services\DataBuilder;
use App\Services\Decoder\Context;
use App\Services\Decoder\Csv\Csv;

class IndexController
{
    public function index()
    {
        httpMethod('get');

        (new \App\Views\IndexView())->output();
    }

    public function upload()
    {
        httpMethod('post');

        (new FileValidator($_FILES['file']))
            ->required()
            ->type('text/csv')
            ->validate();

        //strategy for executing required file parser
        (new Context(new Csv()))
            ->parseFile()
            ->saveToDb();

        header('Location: ' . '/?action=show');
        exit();
    }

    public function show()
    {
        httpMethod('get');

        $calls = Call::query()->get()->toArray();

        (new \App\Views\StatisticView())->output((new DataBuilder($calls))->build());
    }
}