<?php

namespace PlugSurfingDemoBundle\Entity;

/**
 * Project: PlugSurfingDemo
 * User: Dave
 * Date: 22/09/2016
 * Time: 23:18
 */

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class CSVFile
{
    /**
     * @Assert\NotBlank(message="Please, upload a CSV file.")
     * @Assert\File(mimeTypes={ "text/csv","text/plain" })
     */
    private $csvFile;

    /**
     * @var string
     */
    private $outputFormat;

    /**
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getCSVFile()
    {
        return $this->csvFile;
    }

    /**
     * @param $csvFile
     * @return $this
     */
    public function setCSVFile($csvFile)
    {
        $this->csvFile = $csvFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getOutputFormat()
    {
        return $this->outputFormat;
    }

    /**
     * @param mixed $outputFormat
     */
    public function setOutputFormat($outputFormat)
    {
        $this->outputFormat = $outputFormat;
    }
}