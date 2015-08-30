<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Description of RoleController
 *
 * @author Flash
 */
class RoleController extends Controller {

//basic user(staff) interface generator
    public function userAction() {
        return $this->render("ClassUserBundle:Profiles:user.html.twig");
    }

//basic Student interface generator
    public function studentAction($student_id) {
        $conn = $this->getDoctrine()->getConnection();
        $query = "SELECT * FROM person inner join student on person.username=student.id where student.id=:student_id";
        $mobileQuery = " SELECT * FROM contact_numbers where person_id=:student_id";
        $registeredClass = " SELECT * FROM `student_register` inner join class on class.id=student_register.class_id "
                . "inner join teacher on class.teacher_id=teacher.id "
                . "where student_id=:student_id";
        $stmt = $conn->prepare($query);
        $stmtMobile = $conn->prepare($mobileQuery);
        $stmtRegClass = $conn->prepare($registeredClass);

        $stmt->execute(array(
            'student_id' => $student_id
        ));
        $stmtMobile->execute(array(
            'student_id' => $student_id
        ));
        $stmtRegClass->execute(array(
            'student_id' => $student_id
        ));
        $result = $stmt->fetchAll();
        $resultMobile = $stmtMobile->fetchAll();
        $resultRegClass = $stmtRegClass->fetchAll();

        if ($resultMobile == null) {
            $resultMobile = null;
        }

        return $this->render("ClassUserBundle:Profiles:student.html.twig", array(
                    'student' => $result,
                    'mobile' => $resultMobile,
                    'classes' => $resultRegClass
        ));
    }

//basic teacher interface generator
    public function teacherAction() {
        $teacher = $this->container->get("security.context")->getToken()->getUser();
        $id = $teacher->getUsername();

        $em = $this->getDoctrine()->getManager();
        $teacher = $em->getRepository('ClassUserBundle:Teacher')->find($id);
        $mobile = $em->getRepository('ClassUserBundle:Mobile')->findBy(array(
            'personId' => $id,
        ));
        $class = $em->getRepository('ClassUserBundle:TutionClass')->findBy(array(
            'teacher_id' => $id,
        ));


        return $this->render("ClassUserBundle:Profiles:teacher.html.twig", array(
                    'teacher' => $teacher,
                    'mobile' => $mobile,
                    'class' => $class
        ));
    }

//basic super admin interface generator
    public function superAdminAction() {
        $admin = $this->container->get('security.context')->getToken()->getUser();
        return $this->render("ClassUserBundle:Profiles:superAdmin.html.twig", array(
                    'admin' => $admin,
        ));
    }

//    this action is to decide which page should be redirected to as soon as logged in

    public function roleSelectAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $roles = $user->getRoles();
        $userId = $user->getUsername();

//      if role is default then load student student being treated as default role
        if ($roles[0] == 'ROLE_STUDENT') {
//            return $this->redirect($this->generateUrl('Profile_student'))
            return new RedirectResponse($this->generateUrl('Profile_student'), array(
                'student_id' => $userId
            ));
        }
//        if role is admin then load staff(user) being treated as admin role
        else if ($roles[0] == 'ROLE_USER') {
            return $this->redirect($this->generateUrl('Profile_user'));
//            return new RedirectResponse($this->generateUrl('Profile_user'));
        }
//        if role is teacher then load student being treated as teacher role
        else if ($roles[0] == 'ROLE_TEACHER') {
            return new RedirectResponse($this->generateUrl('Profile_teacher'));
        }
//        if role is super admin then load student being treated as super admin role
        else if ($roles[0] == 'ROLE_SUPER_ADMIN') {
            return new RedirectResponse($this->generateUrl('Profile_superAdmin'));
        } else {
            return new \Symfony\Component\HttpFoundation\Response('Error');
        }
    }

}
