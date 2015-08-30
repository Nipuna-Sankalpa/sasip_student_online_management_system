<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of Settings
 *
 * @author Flash
 */
class SettingsController extends Controller {

    public function displayStudentProfileAction() {
        $form = $this->container->get('fos_user.change_password.form');
        return $this->render('UserBundle:Security:personalSettings.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function displayPasswordResetAction(Request $request) {
        $token = $request->get('token');
        $form = $this->container->get('fos_user.resetting.form');
        $content = $this->render('UserBundle:Resetting:UserProfileSettings.html.twig', array(
            'form' => $form->createView(),
            'token' => $token,
        ));

        return $content;
    }

    public function renderUserRequestAction() {
        return $this->render('UserBundle:Resetting:RequestUser.html.twig');
    }

}
