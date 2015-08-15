<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of NewsForum
 *
 * @author Flash
 */
class NewsForumController extends Controller {

    public function sendMsgAction(Request $request) {
        
    }

    public function displayForumAction() {
        return $this->render('ClassUserBundle:Profiles/Student:newsForum.html.twig');
    }

}
