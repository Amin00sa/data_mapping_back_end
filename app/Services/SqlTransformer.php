<?php

namespace App\Services;

class SqlTransformer{
    /**
     * @param $sql
     * @return array
     */
    public function getAttribute($sql): array
    {
        $sql = str_replace('`', '', $sql);
        preg_match('/INSERT INTO (.*) VALUES/', $sql, $matches);
        preg_match('/INSERT INTO (\w+)/', $sql, $matchesName);
        $tableName = $matchesName[1];
        $matches[1] = str_replace([$tableName,'(',')',' '],"",$matches[1]);
        return explode(',', $matches[1]);
    }

    /**
     * @param $sql
     * @param $attributes
     * @return array
     */
    public function getData($sql, $attributes): array
    {
        $sql = str_replace('`', '', $sql);
        preg_match('/INSERT INTO .* VALUES(.*);/s', $sql, $matches);
        $values = explode('),', trim($matches[1], '()'));
        $data = array();
        foreach ($values as $value) {
            $data[] = str_getcsv($value, ',', "'");
        }
        $data = array_map(function ($value) {
            return str_replace(["\"\"\"", "\r", "\n", "(","'"], '', $value);
        }, $data);
        $transformedData = array();
        foreach ($data as $valueData) {
            $temp = array();
            foreach ($attributes as $key => $value) {
                $temp[$value] = $valueData[$key];
            }
            $transformedData[] = $temp;
        }
        return $transformedData;
    }
}
