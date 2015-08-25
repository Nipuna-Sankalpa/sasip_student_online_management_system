<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sasip\ClassUserBundle\Entity\Student;
use Sasip\ClassUserBundle\Form\RegistrationForm;
use Symfony\Component\HttpFoundation\JsonResponse;

class SettingsController extends Controller {

    public function studentProfileAction(Request $request) {
        $student = new Student();

        $studentForm = $this->createForm(new RegistrationForm(), $student);

        $studentForm->handleRequest($request);
        if ($studentForm->isValid()) {
            $mobile = $student->getMobile();
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            $em->persist($mobile);
            $em->flush();
            return;
        }
        return $this->render('ClassUserBundle:Profiles/Student/Utility:AccountSettings.html.twig', array(
                    'form' => $studentForm->createView()
        ));
    }

    public function studentUpdateProfileAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $id = $user->getUsername();

        $student = $em->getRepository('ClassUserBundle:Student')->find($id);
        $studentForm = $this->createForm(new RegistrationForm(), $student);
//        $studentForm->handleRequest($request);
        if ($request->getMethod() == 'POST') {
            $DATA=$studentForm->getData();
//            $student->setPortfolio($request->get('sasip_registration_form_portfolio'));
//
//            $student->setFirstName($request->get('sasip_registration_form_first_name'));
//            $student->setLastName($request->get('sasip_registration_form_last_name'));
//            $student->setDateOfBirth($request->get('sasip_registration_form_dateOfBirth'));
//            $student->setGender($request->get('sasip_registration_form_gender'));
////            $student->setImage($request->get(''));
//            $student->setParentName($request->get('sasip_registration_form_parentName'));
//            $student->setParent_mobile($request->get('sasip_registration_form_parentMobile'));
//            $student->setAddress($request->get('sasip_registration_form_address'));
//            $student->setSchool($request->get('sasip_registration_form_school'));
//            $student->setYearOfExam($request->get('sasip_registration_form_year_of_exam'));
//            $em->flush();
            return new JsonResponse(array(
                'message' => $DATA
            ));
        }
        return new JsonResponse(array(
            'message' => $id
        ));
    }

    public function teacherProfileAction() {
        
    }

    public function userProfileAction() {
        
    }

    public function supAdminProfileAction() {
        
    }

    public function sendDataAction(Request $request) {
        if ($request->getMethod() == 'POST') {
            $conn = $this->getDoctrine()->getConnection();
            $query = "SELECT * FROM student inner join "
                    . "contact_numbers on student.id=contact_numbers.person_id "
                    . "where student.id= :id";
            $stmt = $conn->prepare($query);
            $stmt->execute(array(
                'id' => $request->get('id'),
            ));
            $result = $stmt->fetchAll();
            return new JsonResponse($result);
        } else {
            return new JsonResponse(array(
                'message' => 'ERROR',
            ));
        }
    }

}
