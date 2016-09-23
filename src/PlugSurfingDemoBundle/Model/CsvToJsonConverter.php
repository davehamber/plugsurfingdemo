<?php
/**
 * Project: PlugSurfingDemo
 * User: Dave
 * Date: 23/09/2016
 * Time: 17:05
 */

namespace PlugSurfingDemoBundle\Model;

/**
 * Class CsvToJsonConverter
 * @package PlugSurfingDemoBundle\Model
 *
 * Converts CSV data to json data
 */
class CsvToJsonConverter implements CsvConverterInterface
{
    const FILE_EXTENSION = '.json';

    /**
     * @param string $pathToCsv
     * @return string
     */
    public function convertCSVFile($pathToCsv)
    {
        $dataSet = array();
        $i = 0;

        $h = fopen($pathToCsv, 'r');
        $columnNames = fgetcsv($h);

        while (($row = fgetcsv($h)) !== false) {
            $dataSet[$i++] = array_combine($columnNames, $row);
        }
        fclose($h);

        return json_encode($dataSet);
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return static::FILE_EXTENSION;
    }
}