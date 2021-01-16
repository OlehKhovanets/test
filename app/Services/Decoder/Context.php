<?php

namespace App\Services\Decoder;

use App\Services\Decoder\Csv\Csv;

class Context
{
    private $strategy;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function parseFile(): Context
    {
        $this->strategy->parseFile();
        return $this;
    }

    public function saveToDb(): void
    {
        $this->strategy->saveToDb();
    }
}