<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sasip\ClassUserBundle\Entity\Exams;
use Sasip\ClassUserBundle\Form\ExamForm;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Description of ExamConfigController
 *
 * @author Flash
 */
class ExamConfigController extends Controller {

    //put your code here
    public function examConfigAction(Request $request) {

        $exam = new Exams();
        $form = $this->createForm(new ExamForm(), $exam);
        $form->add('teacher_id', 'choice', array(
            'choices' => $this->getTeacherList(),
            'placeholder' => 'Select Conducting Teacher'
        ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($exam);
            $em->flush();

            return new JsonResponse(array(
                'message' => 'Class Successfully created !'
            ));
        }

        return $this->render('ClassUserBundle:Profiles/SuperAdmin:ExamConfiguration.html.twig', array(
                    'form' => $form->createView(),
                    'examList' => $this->getExamList()
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

    public function getExamList() {
        $exams = $this->getDoctrine()->getManager()->getRepository('ClassUserBundle:Exams')->findAll();
        return $exams;
    }

    //this method is to update class details

    public function updateAction(Request $request) {
        $ExamId = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $exam = $em->getRepository('ClassUserBundle:Exams')->find($ExamId);

        //under this condition edit form will filled with the existing data
        //when class being selected this mehtod will be invoked.

        if ($request->getMethod() == 'GET' && $exam != null) {

            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            $jsonContent = $serializer->serialize($exam, 'json');

            return new \Symfony\Component\HttpFoundation\Response($jsonContent);
        }

        //this conditon will work when data being submitted through the form

        if ($request->getMethod() == 'POST' && $exam != null) {
            if ($request->request->get('fees')) {
                $exam->setFees($request->request->get('fees'));
            }            
            if ($request->request->get('conductDay')) {
                $exam->setConductDay($request->request->get('conductDay'));
            }
            if ($request->request->get('time')) {
                $exam->setTime($request->request->get('time'));
            }
            if ($request->request->get('teacher_id')) {
                $exam->setTeacherid($request->request->get('teacher_id'));
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
