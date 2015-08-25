<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sasip\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use FOS\UserBundle\Model\UserInterface;

//FOS registration controller is overridden by Sasip/UserBundle registration controller

class RegistrationController extends BaseController {

//    this method need to be evolved after the front being develpoed
    public function registerAction() {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            $authUser = false;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $authUser = true;
                $route = 'fos_user_registration_confirmed';
            }

//            $this->setFlash('fos_user_success', 'registration.flash.user_created');
//            $url = $this->container->get('router')->generate($route);
//            $response = new RedirectResponse($url);


            return new \Symfony\Component\HttpFoundation\JsonResponse(array(
                'message' => 'Registration Successful'
            ));
        }

        return $this->container->get('templating')->renderResponse('UserBundle:Registration:register_content.html.' . $this->getEngine(), array(
                    'form' => $form->createView(),
        ));
    }

}
