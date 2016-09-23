<?php
/**
 * Project: PlugSurfingDemo
 * User: Dave
 * Date: 23/09/2016
 * Time: 17:10
 */

namespace PlugSurfingDemoBundle\Model;


interface CsvConverterInterface
{
    /**
     * @param string $pathToCsv
     * @return string
     *
     * Converts string data from the csv format to the chosen format
     */
    function convertCSVFile($pathToCsv);

    /**
     * @return string
     *
     * Gets file extension for the given format
     */
    public function getExtension();
}