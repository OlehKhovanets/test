<?php

namespace App\Services\Decoder;

interface Strategy
{
    public function parseFile();

    public function saveToDb();
}