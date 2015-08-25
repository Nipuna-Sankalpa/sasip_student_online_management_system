<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

}
