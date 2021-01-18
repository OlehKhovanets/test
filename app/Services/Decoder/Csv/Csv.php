<?php

namespace App\Services\Decoder\Csv;

use App\Models\Call;
use App\Services\Decoder\Strategy;

class Csv implements Strategy
{
    protected $data;

    public function parseFile(): Csv
    {
        $dataFromFile = [];

        $row = 1;
        $i = 0;
        if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    $dataFromFile[$i][] = $data[$c];
                }
                $i++;
            }

            fclose($handle);
        }

        $this->data = $dataFromFile;
        return $this;
    }

    public function buildCalls(): array
    {
        $i = 0;
        $calls = [];

        foreach ($this->data as $item) {
            try {

                if (!isJson($output = curl(arrGet($item, $item[4])))) {
                    continue;
                }

                $calls[] = [
                    'customer_id' => arrGet($item, $item[10]),
                    'call_date' => arrGet($item, $item[1]),
                    'duration' => arrGet($item, $item[2]),
                    'phone_number' => arrGet($item, $item[3]),
                    'ip' => arrGet($item, $item[4]),
                    'continent_code' => json_decode($output, true)['continent_code']
                ];
                $i++;

            } catch (\Throwable $exception) {
                continue;
            }
        }

        return $calls;
    }
}