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
        $calls = (new Context(new Csv()))
            ->parseFile()
            ->buildCalls();

        if(!empty($calls)) {
            Call::query()->delete();
            Call::query()->insert($calls);
        }

        header('Location: ' . '/?action=show');
        exit();
    }

    public function show()
    {
        httpMethod('get');

        (new \App\Views\StatisticView())->output((new DataBuilder(Call::query()->get()->toArray()))->build());
    }
}