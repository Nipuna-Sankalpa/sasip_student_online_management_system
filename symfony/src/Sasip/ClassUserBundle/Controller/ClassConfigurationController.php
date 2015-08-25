<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sasip\ClassUserBundle\Entity\TutionClass;
use Sasip\ClassUserBundle\Form\ClassForm;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Description of ClassConfigurationController
 *
 * @author Flash
 */
class ClassConfigurationController extends Controller {

    //put your code here
// this function will render the class creation template and
// saves newly created classes into database
    public function classConfigAction(Request $request) {

        $tution = new TutionClass();
        $form = $this->createForm(new ClassForm(), $tution);
        $form->add('teacher_id', 'choice', array(
            'choices' => $this->getTeacherList(),
            'placeholder' => 'Select Conducting Teacher'
        ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tution);
            $em->flush();

            return new JsonResponse(array(
                'message' => 'Class Successfully created !'
            ));
        }

        return $this->render('ClassUserBundle:Profiles/SuperAdmin:ClassConfiguration.html.twig', array(
            'form' => $form->createView(),
            'classList' => $this->getClassList()
        ));
    }

    //this function helps to retrieve all the teachers with their IDs from the database.

    public function getTeacherList() {
        $arrrayTeachers = null;
        $teachers = $this->getDoctrine()->getManager()->getRepository('ClassUserBundle:Teacher')->findAll();
        if ($teachers) {
            foreach ($teachers as $teacher) {
                $arrrayTeachers[$teacher->getId()] = $teacher->getFirstName() . " " . $teacher->getLastName();
            }
        }

        return $arrrayTeachers;
    }

    public function getClassList() {
        $classes = $this->getDoctrine()->getManager()->getRepository('ClassUserBundle:TutionClass')->findAll();
        return $classes;
    }

    //this method is to update class details

    public function updateAction(Request $request) {
        $ClassId = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $class = $em->getRepository('ClassUserBundle:TutionClass')->find($ClassId);

        //under this condition edit form will filled with the existing data
        //when class being selected this mehtod will be invoked.
        
        if ($request->getMethod() == 'GET' && $class != null) {

            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            $jsonContent = $serializer->serialize($class, 'json');

            return new \Symfony\Component\HttpFoundation\Response($jsonContent);
        }
        
        //this conditon will work when data being submitted through the form

        if ($request->getMethod() == 'POST' && $class != null) {
            if ($request->request->get('fees')) {
                $class->setFees($request->request->get('fees'));
            }
            if ($request->request->get('conductDay')) {
                $class->setConductDay($request->request->get('conductDay'));
            }
            if ($request->request->get('time')) {
                $class->setTime($request->request->get('time'));
            }
            if ($request->request->get('teacher_id')) {
                $class->setTeacherid($request->request->get('teacher_id'));
            }

            $em->flush();
            return new JsonResponse(array(
                'message' => 'Updated Successfully'
                    ));
        }
        return new JsonResponse(array(
            'message' => 'ERROR'
                ));
    }

}
