<?php
/**
 * Project: PlugSurfingDemo
 * User: Dave
 * Date: 23/09/2016
 * Time: 17:50
 */

namespace PlugSurfingDemoBundle\Model;


use Symfony\Component\Config\Definition\Exception\Exception;

class CsvConverterFactory
{
    /**
     * Current convertible types
     */
    const JSON = 0;
    const XML = 1;

    /**
     * @param $converterType
     * @return CsvConverterInterface
     */
    public static function getConverter($converterType)
    {
        switch ($converterType) {
            case CsvConverterFactory::JSON:
                return new CsvToJsonConverter();
            case CsvConverterFactory::XML:
                return new CsvToXmlConverter();
        }

        throw new Exception("CSV Converter".$converterType." does not exist.");
    }
}