<?php

namespace Jhekasoft\Bundle\TestformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JhekasoftTestformBundle:Default:index.html.twig');
    }
}
