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
use Sasip\ClassUserBundle\Entity\Teacher;
use Sasip\ClassUserBundle\Form\RegistrationForm;
use Sasip\ClassUserBundle\Form\TeacherRegisterForm;
use Symfony\Component\HttpFoundation\JsonResponse;

class SettingsController extends Controller {

    public function studentProfileAction(Request $request) {
        $student = new Student();
        $userID = $this->container->get('security.context')->getToken()->getUser()->getUsername();
        $studentForm = $this->createForm(new RegistrationForm(), $student);

        $studentForm->handleRequest($request);
        if ($studentForm->isValid()) {
            $mobile = $student->getMobile();
            $em = $this->getDoctrine()->getManager();
            $student->setId($userID);
            $student->setWebPath($userID);
            $student->upload();
            $em->persist($student);
            $em->flush();
            $em->persist($mobile);
            $em->flush();
            return $this->redirectToRoute('Profile_student', array(
                        'student_id' => $userID,
            ));
        }
        return $this->render('ClassUserBundle:Profiles/Student/Utility:AccountSettings.html.twig', array(
                    'form' => $studentForm->createView()
        ));
    }

    //when user login for his first time this method will get executed and registration form will be appeared.

    public function initialSettingAction() {
        return $this->render("ClassUserBundle:Profiles:AccountSettingsContainer.html.twig");
    }

    public function studentUpdateProfileAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $id = $user->getUsername();

        $student = $em->getRepository('ClassUserBundle:Student')->find($id);
        $mobile = $em->getRepository('ClassUserBundle:Mobile')->find($id);
        $studentForm = $this->createForm(new RegistrationForm(), $student);
        $studentForm->handleRequest($request);


        if ($request->getMethod() == 'POST') {

            if ($studentForm->isValid()) {
                $mobile = $student->getMobile();

                $student->setWebPath($id);
                $student->upload();

                $em->flush();
                return $this->redirectToRoute('Profile_student', array(
                            'student_id' => $id,
                ));
            }
        }

        return new Response('ERROR');
    }

    public function teacherProfileAction(Request $request) {
        $teacher = new Teacher();
        $form = $this->createForm(new TeacherRegisterForm(), $teacher);
        $form->handleRequest($request);
        $id = $this->container->get('security.context')->getToken()->getUser()->getId();
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $teacher->setId($id);
            $mobile1 = $teacher->getMobile1();
            $mobile2 = $teacher->getMobile2();

            $teacher->setWebPath($id);
            $teacher->upload();

            $em->persist($mobile2);
            $em->persist($mobile1);
            $em->persist($teacher);
            $em->flush();

            return $this->redirectToRoute('Profile_teacher');
        }

        return $this->render('ClassUserBundle:Profiles/Teacher/Utility:AccountSettings.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function teacherUpdateProfileAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $this->container->get('security.context')->getToken()->getUser()->getId();

        $teacher = $em->getRepository('ClassUserBundle:Teacher')->find($id);
        $form = $this->createForm(new TeacherRegisterForm(), $teacher);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $teacher->setWebPath($id);
            $teacher->upload();
            $em->flush();
            return $this->redirectToRoute('Profile_teacher');
        }

        return new Response('ERROR');
    }

    public function sendDataAction(Request $request) {
        if ($request->getMethod() == 'POST') {
            $conn = $this->getDoctrine()->getConnection();
            $query = "SELECT * FROM student where student.id= :id";
            $stmt = $conn->prepare($query);
            $stmt->execute(array(
                'id' => $request->get('id'),
            ));
            $result_profile = $stmt->fetchAll();

            $query = "SELECT * FROM contact_numbers where person_id= :id";
            $stmt = $conn->prepare($query);
            $stmt->execute(array(
                'id' => $request->get('id'),
            ));
            $result_contact = $stmt->fetchAll();


            return new JsonResponse(array(
                'profile' => $result_profile,
                'contact' => $result_contact,
            ));
        } else {
            return new JsonResponse(array(
                'message' => 'ERROR',
            ));
        }
    }

    public function sendDataTeacherAction(Request $request) {
        if ($request->getMethod() == 'POST') {
            $conn = $this->getDoctrine()->getConnection();
            $query = "SELECT * FROM teacher where teacher.id= :id";
            $stmt = $conn->prepare($query);
            $stmt->execute(array(
                'id' => $request->get('id'),
            ));
            $result_profile = $stmt->fetchAll();

            $query = "SELECT * FROM contact_numbers where person_id= :id ";

            $stmt = $conn->prepare($query);
            $stmt->execute(array(
                'id' => $request->get('id'),
            ));
            $result_contact = $stmt->fetchAll();

            return new JsonResponse(array(
                'profile' => $result_profile,
                'contact' => $result_contact
            ));
        } else {
            return new JsonResponse(array(
                'message' => 'ERROR',
            ));
        }
    }

}
