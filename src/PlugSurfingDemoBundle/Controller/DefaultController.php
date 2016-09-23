<?php

namespace PlugSurfingDemoBundle\Controller;

use PlugSurfingDemoBundle\Entity\CSVFile;
use PlugSurfingDemoBundle\Form\Type\CsvUploadType;
use PlugSurfingDemoBundle\Model\CsvConverter;
use PlugSurfingDemoBundle\Model\CsvConverterFactory;
use PlugSurfingDemoBundle\Model\CsvToJsonConverter;
use PlugSurfingDemoBundle\Model\CsvToXmlConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $csvFile = new CSVFile();
        $form = $this->createForm(CsvUploadType::class, $csvFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $csvConverter = new CsvConverter($csvFile);
            $contents = $csvConverter->convertCsvFile();
            $newFileName = $csvConverter->getNewFileName();

            $response = $this->render(
                'PlugSurfingDemoBundle:Default:download.html.twig',
                array('data' => $contents)
            );

            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', 'attachment; filename="'.$newFileName.'"');

            return $response;
        }

        return $this->render(
            'PlugSurfingDemoBundle:Default:index.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

}
