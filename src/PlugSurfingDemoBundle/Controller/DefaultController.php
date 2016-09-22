<?php

namespace PlugSurfingDemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PlugSurfingDemoBundle:Default:index.html.twig');
    }
}
