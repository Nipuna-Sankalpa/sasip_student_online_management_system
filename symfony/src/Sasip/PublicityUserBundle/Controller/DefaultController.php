<?php

namespace Sasip\PublicityUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;


class DefaultController extends Controller {

    public function indexAction() {

        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        return $this->render('PublicityUserBundle:Default:index.html.twig', array(
                    'csrf_token' => $csrfToken,
                    'last_username' => $lastUsername
        ));
    }

}
