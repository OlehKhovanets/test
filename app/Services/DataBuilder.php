<?php

namespace App\Services;

class DataBuilder
{
    protected $calls;

    public function __construct(array $calls)
    {
        $this->calls = $calls;
    }

    public function groupByCustomerId(): array
    {
        $arrCustomerIds = [];
        /*group all list of calls by customer_id*/
        foreach ($this->calls as $key => $item) {
            $arrCustomerIds[$item['customer_id']][$key] = $item;
        }

        ksort($arrCustomerIds, SORT_NUMERIC);

        return $arrCustomerIds;
    }

    public function groupByContinentCodes(array $value): array
    {
        $totalDuration = 0;
        $continentCodesArr = [];

        /*group list of calls grouped by customer_id by continent_code*/
        foreach ($value as $key => $item) {
            $totalDuration += $item['duration'];
            $continentCodesArr[$item['continent_code']][$key] = $item;
        }

        ksort($continentCodesArr, SORT_NUMERIC);

        return ['duration' => $totalDuration, 'continentCodesArr' => $continentCodesArr];
    }

    public function build(): array
    {
        $arrCustomerIds = $this->groupByCustomerId();

        $output = [];
        $outputCount = 0;

        foreach ($arrCustomerIds as $key => $value) {

            $output[$outputCount]['customer_id'] = $key;

            $totalDuration = $this->groupByContinentCodes($value)['duration'];
            $continentCodesArr = $this->groupByContinentCodes($value)['continentCodesArr'];

            /*loop for each continent code*/
            foreach ($continentCodesArr as $continent => $continentCodeArr) {
                $durationByContinentCode = 0;
                $output[$outputCount]['continent'][$continent]['calls'] = count($continentCodeArr);

                foreach ($continentCodeArr as $item) {
                    $durationByContinentCode += $item['duration'];
                }

                $output[$outputCount]['continent'][$continent]['duration'] = $durationByContinentCode;

            }

            $output[$outputCount]['total_calls'] = count($value);
            $output[$outputCount]['total_duration'] = $totalDuration;
            $outputCount++;
        }

        return $output;

    }
}