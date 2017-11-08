<?php

namespace Podlatch\PublisherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PublisherBundle:Default:index.html.twig');
    }
}
