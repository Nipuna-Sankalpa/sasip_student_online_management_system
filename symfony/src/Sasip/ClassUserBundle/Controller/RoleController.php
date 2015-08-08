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
    public function studentAction() {
        return $this->render("ClassUserBundle:Profiles:student.html.twig");
    }

//basic teacher interface generator
    public function teacherAction() {
        return $this->render("ClassUserBundle:Profiles:teacher.html.twig");
    }

//    this action is to decide which page should be redirected to as soon as logged in

    public function roleSelectAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $roles[] = $user->getRole();
//        if role is default then load student student being treated as default role
        if ($roles[0] == 'ROLE_DEFAULT') {
            new RedirectResponse($this->generateUrl('Profile_student'));
        }
//        if role is admin then load staff(user) being treated as admin role
        else if ($roles[0] == 'ROLE_ADMIN') {
            new RedirectResponse($this->generateUrl('Profile_user'));
        }
//        if role is teacher then load student being treated as teacher role
        else if ($roles[0] == 'ROLE_TEACHER') {
            new RedirectResponse($this->generateUrl('Profile_teacher'));
        }
//        if role is super admin then load student being treated as super admin role
        else if ($roles[0] == 'ROLE_SUPER_ADMIN') {
            new RedirectResponse($this->generateUrl(''));
        }
    }

}
