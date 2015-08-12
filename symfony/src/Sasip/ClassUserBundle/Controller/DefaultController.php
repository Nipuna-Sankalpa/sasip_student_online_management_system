<?php

namespace Sasip\ClassUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClassUserBundle:Default:index.html.twig');
    }
}
