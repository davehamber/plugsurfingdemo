<?php
/**
 * Project: PlugSurfingDemo
 * User: Dave
 * Date: 23/09/2016
 * Time: 17:15
 */

namespace PlugSurfingDemoBundle\Model;

use SimpleXMLElement;

/**
 * Class CsvToXmlConverter
 * @package PlugSurfingDemoBundle\Model
 *
 * Converts CSV data to XML data
 */
class CsvToXmlConverter
{
    const FILE_EXTENSION = '.xml';

    /**
     * @param $pathToCsv
     * @return string
     */
    function convertCSVFile($pathToCsv)
    {
        $xml = new SimpleXMLElement('<xml/>');

        $h = fopen($pathToCsv, 'r');
        $columnNames = array_map('trim', fgetcsv($h));

        while (($row = fgetcsv($h)) !== false) {
            $row = array_map('trim', $row);

            $rowData = array_combine($columnNames, $row);
            $row = $xml->addChild('row');

            foreach ($rowData as $key => $value) {
                $row->addChild($key, $value);
            }
        }

        fclose($h);

        return $xml->asXML();
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return static::FILE_EXTENSION;
    }
}