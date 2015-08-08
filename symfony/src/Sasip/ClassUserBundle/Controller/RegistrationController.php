<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sasip\ClassUserBundle\Form\RegistrationForm;
use Sasip\ClassUserBundle\Entity\Student;
use Sasip\ClassUserBundle\Entity\Teacher;
use Sasip\ClassUserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

//this controller is being used for handle online temporary registration.                     

class RegistrationController extends Controller {

//    this method is used to register students information not account details.

    public function registerStudentAction(Request $request) {
        $student = new Student();
//        create form and assign student object
        $form = $this->createForm(new RegistrationForm, $student, array(
            'action' => '#',
            'method' => 'POST'
        ));
//        request being handled.while that is happening if the request
//        consist data, then student object will be assigned with that data
        $form->handleRequest($request);

        if ($form->isValid()) {
//flush data in to the sql table
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirect('#');
        }
        return $this->render('#', array(
                    'regForm' => $form->createView()
        ));
    }

    public function registerTeacherAction(Request $request) {
        $teacher = new Teacher();

        $form = $this->createForm(new RegistrationForm(), $teacher, array(
            'action' => '#',
            'method' => 'POST'
        ));

        $form->handleRequest();
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teacher);
            $em->flush();

            return $this->redirect('#');
        }

        return $this->render('#', array(
                    'regForm' => $form->createView()
        ));
    }

    public function registerUserAction(Request $request) {
        $user = new User();

        $form = $this->createForm(new RegistrationForm(), $user, array(
            'action' => '#',
            'method' => 'POST'
        ));

        $form->handleRequest();
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect('#');
        }

        return $this->render('#', array(
                    'regForm' => $form->createView()
        ));
    }

}
