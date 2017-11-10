<?php

namespace Podlatch\PublisherBackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PublisherBackendBundle:Default:index.html.twig');
    }
}
