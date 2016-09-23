<?php
/**
 * Project: PlugSurfingDemo
 * User: Dave
 * Date: 23/09/2016
 * Time: 19:06
 */

namespace PlugSurfingDemoBundle\Model;


use PlugSurfingDemoBundle\Entity\CSVFile;

class CsvConverter
{
    private $csvFile;
    private $converter;

    /**
     * CsvConverter constructor.
     * @param CSVFile $csvFile
     */
    public function __construct(CSVFile $csvFile)
    {
        $this->csvFile = $csvFile;
    }

    /**
     * @return string
     *
     * Using the output format specified in the radio button on the form
     * we use a factory to get the specific file format converter
     */
    public function convertCsvFile()
    {
        $outputFormat = $this->csvFile->getOutputFormat();
        $this->converter = CsvConverterFactory::getConverter($outputFormat);

        /**
         * @param $file \Symfony\Component\HttpFoundation\File\UploadedFile
         */
        $file = $this->csvFile->getCSVFile();

        return $this->converter->convertCSVFile($file->getPathname());
    }

    /**
     * @return string
     *
     * Returns the new file name based on the old file name but with the extension
     * replaced for the new format.
     */
    public function getNewFileName()
    {
        /**
         * @param $file \Symfony\Component\HttpFoundation\File\UploadedFile
         */
        $file = $this->csvFile->getCSVFile();

        $originalFileName = $file->getClientOriginalName();
        $pathInfo = pathinfo($originalFileName);

        return $pathInfo['filename'].$this->converter->getExtension();
    }
}