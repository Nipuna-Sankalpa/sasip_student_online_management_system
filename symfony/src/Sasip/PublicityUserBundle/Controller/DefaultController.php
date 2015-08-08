<?php

namespace Sasip\PublicityUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PublicityUserBundle:Default:index.html.twig');
    }
}
