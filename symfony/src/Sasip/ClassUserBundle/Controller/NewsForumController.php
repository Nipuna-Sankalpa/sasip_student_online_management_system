<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Controller;

use Sasip\ClassUserBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of NewsForum
 *
 * @author Flash
 */
class NewsForumController extends Controller {

//    this method was omplemented in order to hande messages passing here and there
//    message content,title,receiver was taken from the forum which is submitted from the front end
    //jason response benig sent into front end according to the success or failure
    public function sendMsgAction(Request $request) {
        $student = $this->container->get('security.context')->getToken()->getUser();
        $dateTime = new \DateTime();

        $message = new Message();
        if ($request->getMethod() == 'POST') {
            $time = $dateTime->format('h:i A');
            $date = $dateTime->format('d M Y');
            $message->setContent($request->get('message'));
            $message->setState('unread');
            $message->setSender($student->getUsername());
            $message->setStudent_id($student->getUsername());
            $message->setTeacher_id($request->get('receiver'));
            $message->setTitle($request->get('title'));
            $message->setTimeSent("$time");
            $message->setDateSent("$date");

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return new JsonResponse(array(
                'message' => 'Message sent successfully'
            ));
        }
        return new JsonResponse(array(
            'message' => 'Message sent fail !'
        ));
    }

//    this function renders newsforum template with required data

    public function displayForumAction() {

        $student = $this->container->get('security.context')->getToken()->getUser();
        $student_id = $student->getUsername();
        $conn = $this->getDoctrine()->getConnection();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            $query_message = "SELECT *,concat(first_name,' ',last_name) as teacherName FROM send_messages INNER JOIN teacher ON teacher.id=send_messages.teacher_id"
                    . " WHERE student_id= :student_id ORDER BY time_sent DESC limit 10";
            $query_teacher = "select teacher_id,concat(first_name,' ',last_name) as teacher_name from"
                    . " student_register inner join class on student_register.class_id=class.id inner join teacher on teacher.id=class.teacher_id"
                    . " where student_id=:student_id";
        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_STUDENT')) {
            $query_message = "SELECT *,concat(first_name,' ',last_name) as teacherName FROM send_messages INNER JOIN teacher ON teacher.id=send_messages.teacher_id"
                    . " WHERE student_id= :student_id ORDER BY time_sent DESC limit 10";
            $query_teacher = "select teacher_id,concat(first_name,' ',last_name) as teacher_name from"
                    . " student_register inner join class on student_register.class_id=class.id inner join teacher on teacher.id=class.teacher_id"
                    . " where student_id=:student_id";
        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ROLE_SUPER_ADMIN')) {
            $query_message = "SELECT *,concat(first_name,' ',last_name) as teacherName FROM send_messages INNER JOIN teacher ON teacher.id=send_messages.teacher_id"
                    . " WHERE student_id= :student_id ORDER BY time_sent DESC limit 10";
            $query_teacher = "select teacher_id,concat(first_name,' ',last_name) as teacher_name from"
                    . " student_register inner join class on student_register.class_id=class.id inner join teacher on teacher.id=class.teacher_id"
                    . " where student_id=:student_id";
        }

        $stmt = $conn->prepare($query_message);
        $stmt1 = $conn->prepare($query_teacher);
        $stmt->execute(array(
            'student_id' => $student_id
        ));
        $stmt1->execute(array(
            'student_id' => $student_id
        ));

        $result = $stmt->fetchAll();
        $result1 = $stmt1->fetchAll();

        if ($result) {
            return $this->render('ClassUserBundle:Profiles/Student:newsForum.html.twig', array(
                        'messages' => $result,
                        'teachers' => $result1,
            ));
        } else {
            return $this->render('ClassUserBundle:Profiles/Student:newsForum.html.twig', array(
                        'messages' => null,
                        'teachers' => null
            ));
        }
    }

    public function viewMoreAction(Request $request) {
        $conn = $this->getDoctrine()->getConnection();

        if ($request->getMethod() == 'POST') {
            $offset_1 = $request->get('offset_1');
            $offset_2 = $request->get('offset_2');
            $student_id = $request->get('student_id');

            $query = "SELECT * FROM send_messages WHERE "
                    . "student_id= :student_id ORDER BY time_sent DESC limit $offset_1,$offset_2 ";

            $stmt = $conn->prepare($query);
            $stmt->execute(array(
                'student_id' => $student_id,
            ));
            $result = $stmt->fetchAll();

            if ($result) {
                return new JsonResponse(
                        $result
                );
            } else {
                return new JsonResponse();
            }
        }
        return new JsonResponse();
    }

}
