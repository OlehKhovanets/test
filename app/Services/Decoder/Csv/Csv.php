<?php

namespace App\Services\Decoder\Csv;

use App\Models\Call;
use App\Services\Decoder\Strategy;

class Csv implements Strategy
{

    public function parseFile(): Csv
    {
        $dataFromFile = [];

        $row = 1;
        $i = 0;
        if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $row++;
                for ($c=0; $c < $num; $c++) {
                    $dataFromFile[$i][] = $data[$c];
                }
                $i++;
            }

            fclose($handle);
        }

        $this->data = $dataFromFile;
        return $this;
    }

    public function saveToDb(): void
    {
        $i = 0;
        $calls = [];

        foreach ($this->data as $item) {

            $output = curl($item[4]);

            $calls[] = [
                'customer_id' => $item[0] ?? 0,
                'call_date' => $item[1] ?? '',
                'duration' => $item[2] ?? 0,
                'phone_number' => $item[3] ?? '',
                'ip' => $item[4] ?? '',
                'continent_code' => json_decode($output, true)['continent_code'] ?? ''
            ];

            $i++;
        }

        Call::query()->delete();
        Call::query()->insert($calls);
    }
}