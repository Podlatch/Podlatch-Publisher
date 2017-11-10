<?php

namespace Podlatch\PublisherFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PublisherFrontendBundle:Default:index.html.twig');
    }
}
