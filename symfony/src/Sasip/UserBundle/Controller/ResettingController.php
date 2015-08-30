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

use FOS\UserBundle\Controller\ResettingController as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResettingController extends BaseController {

    public function resetAction($token) {
        $user = $this->container->get('fos_user.user_manager')->findUserByUsernameOrEmail($token);

        if ($user == null) {
            return new JsonResponse(array(
                'message' => 'ERROR::User Invalid'
            ));
        }

        $form = $this->container->get('fos_user.resetting.form');
        $formHandler = $this->container->get('fos_user.resetting.form.handler');
        $process = $formHandler->process($user);

        if ($process) {
            $this->setFlash('fos_user_success', 'resetting.flash.success');
            //$response = new RedirectResponse($this->getRedirectionUrl($user));
            //$this->authenticateUser($user, $response);

            return new JsonResponse(array(
                'message' => 'Password reset successfull'
            ));
        }

        return $this->container->get('templating')->renderResponse('UserBundle:Resetting:UserProfileSettings.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
