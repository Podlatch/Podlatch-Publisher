<?php

namespace Podlatch\PublisherCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PublisherCoreBundle:Default:index.html.twig');
    }
}
