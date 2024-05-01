<?php

namespace App\Services;

use Exception;
use SimpleXMLElement;

class XmlTransformer
{
    /**
     * @param $xml
     * @return array
     * @throws Exception
     */
    public function getAttribute($xml): array
    {
        $xmlObject = new SimpleXMLElement($xml);
        $attributes = array();
        foreach ($xmlObject->row[0] as $key => $value) {
            $attributes[] = $key;
        }
        return $attributes;
    }

    /**
     * @param $xml
     * @param $attributes
     * @return array
     * @throws Exception
     */
    public function getData($xml, $attributes): array
    {
        $xmlObject = new SimpleXMLElement($xml);
        $data = array();
        foreach ($xmlObject->row as $row) {
            $temp = array();
            foreach ($attributes as $attribute){
                $temp[$attribute] = (string)$row->$attribute;
            }
            $data[] = $temp;
        }
        return $data;
    }
}
