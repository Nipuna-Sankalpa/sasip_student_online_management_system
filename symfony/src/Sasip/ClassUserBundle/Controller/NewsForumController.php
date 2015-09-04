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
use Sasip\ClassUserBundle\Form\MessagesForm;

/**
 * Description of NewsForum
 *
 * @author Flash
 */
class NewsForumController extends Controller {

//    this method was omplemented in order to hande messages passing here and there
//    message content,title,receiver was taken from the forum which is submitted from the front end
//    json response is sent into frontend according to the success or failure
    public function sendMsgAction(Request $request) {

        $user = $this->container->get('security.context')->getToken()->getUser();
        $dateTime = new \DateTime();
        $message = new Message();

        if ($request->getMethod() == 'POST') {
            $message->setReceiver($request->get('receiver'));
            $message->setTitle($request->get('title'));
            $message->setContent($request->get('content'));
            $message->setState('notRead');
            $message->setSender($user->getUsername());
            $message->setTimeSent($dateTime->format('h:i A'));
            $message->setDateSent($dateTime->format('d M Y'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return new JsonResponse(array(
                'message' => 'Message sent Successfull'
            ));
        }

        return new JsonResponse(array(
            'message' => 'Message sent fail !'
        ));
    }

//    this function renders newsforum template with required data

    public function displayForumAction() {

        $userId = $this->container->get('security.context')->getToken()->getUser()->getUsername();
        $conn = $this->getDoctrine()->getConnection();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            $query_msg_outbox = "select DISTINCT messages.id,state,concat(first_name,' ',last_name) as name,sender,content,date_sent,time_sent,messages.title "
                    . " from messages,student,person where "
                    . " (messages.sender = :userId ) and (messages.receiver = student.id or messages.receiver = person.username) limit 10";
            $query_msg_inbox = "select DISTINCT messages.id,state,concat(first_name,' ',last_name) as name,receiver,content,date_sent,time_sent,messages.title "
                    . " from messages,student,person where"
                    . " (messages.receiver = :userId ) and (messages.sender = student.id or messages.sender = person.username) limit 10";
            $query_sender = "select DISTINCT student.id as id,concat(student.first_name,' ',student.last_name) as name"
                    . " from class inner join student_register on"
                    . " class.id=student_register.class_id inner join student"
                    . " on student.id=student_register.student_id"
                    . " where class.teacher_id= :userId ";

            $stmt = $conn->prepare($query_sender);
            $stmt->execute(array(
                'userId' => $userId
            ));
            $receiver = $stmt->fetchAll();
        }

        if ($this->get('security.authorization_checker')->isGranted('ROLE_STUDENT')) {
            $query_msg_outbox = "select DISTINCT messages.id,state,concat(first_name,' ',last_name) as name,sender,content,date_sent,time_sent,messages.title "
                    . " from messages,teacher,person where "
                    . " (messages.sender = :userId ) and (messages.receiver = teacher.id or messages.receiver = person.username) limit 10";
            $query_msg_inbox = "select DISTINCT messages.id,state,concat(first_name,' ',last_name) as name,receiver,content,date_sent,time_sent,messages.title "
                    . " from messages,teacher,person where"
                    . " (messages.receiver = :userId ) and (messages.sender = teacher.id or messages.sender = person.username) limit 10";
            $query_sender = "select DISTINCT teacher.id as id,concat(first_name,' ',last_name) as name from student_register"
                    . " inner join class on student_register.class_id=class.id inner join teacher on "
                    . "teacher.id=class.teacher_id where student_register.student_id=:userId";

            $stmt = $conn->prepare($query_sender);
            $stmt->execute(array(
                'userId' => $userId
            ));
            $receiver = $stmt->fetchAll();
        }

        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {

            $query_msg_outbox = "select DISTINCT messages.id,state,concat(first_name,' ',last_name) as name,sender,content,date_sent,time_sent,messages.title from messages,teacher where messages.sender =:userId and messages.receiver = teacher.id
                union
                select DISTINCT messages.id,state,concat(first_name,' ',last_name) as name,sender,content,date_sent,time_sent,messages.title from messages,student where messages.sender =:userId and messages.receiver = student.id 
                order by id DESC limit 10";

            $query_msg_inbox = "select DISTINCT messages.id,state,concat(first_name,' ',last_name) as name,sender,content,date_sent,time_sent,messages.title from messages,teacher where messages.receiver =:userId and messages.sender = teacher.id
                union
                select DISTINCT messages.id,state,concat(first_name,' ',last_name) as name,sender,content,date_sent,time_sent,messages.title from messages,student where messages.receiver =:userId and messages.sender = student.id 
                order by id DESC limit 10";

            $query_sender = "select id, concat(first_name,' ',last_name) as name from teacher"
                    . " union "
                    . " select id, concat(first_name,' ',last_name) as name from student";

            $stmt = $conn->prepare($query_sender);
            $stmt->execute();
            $receiver = $stmt->fetchAll();
        }


        $stmt = $conn->prepare($query_msg_outbox);
        $stmt->execute(array(
            'userId' => $userId
        ));
        $outBox = $stmt->fetchAll();

        $stmt = $conn->prepare($query_msg_inbox);
        $stmt->execute(array(
            'userId' => $userId
        ));
        $inBox = $stmt->fetchAll();

        return $this->render('ClassUserBundle:Profiles/Student:newsForum.html.twig', array(
                    'outbox' => $outBox,
                    'inbox' => $inBox,
                    'receiver' => $receiver,
        ));
    }

    public function viewMoreAction(Request $request) {
        $conn = $this->getDoctrine()->getConnection();

        if ($request->getMethod() == 'POST') {
            $offset_1 = $request->get('offset_1');
            $offset_2 = $request->get('offset_2');
            $userId = $request->get('userId');
            $flag = $request->get('flag');
            if ($flag == 'inbox') {
                $query = "SELECT * FROM messages WHERE "
                        . "receiver= :userId ORDER BY time_sent DESC limit $offset_1,$offset_2 ";
            } elseif ($flag == 'outbox') {
                $query = "SELECT * FROM messages WHERE "
                        . "sender= :userId ORDER BY time_sent DESC limit $offset_1,$offset_2 ";
            }

            $stmt = $conn->prepare($query);
            $stmt->execute(array(
                'userId' => $userId,
            ));
            $result = $stmt->fetchAll();

            if ($result) {
                return new JsonResponse($result);
            } else {
                return new JsonResponse(array(
                    'message' => 'no new  messages'
                ));
            }
        }
        return new JsonResponse(array(
            'message' => 'Error'
        ));
    }

    public function markAsReadAction(Request $request) {
        $msgId = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $msg = $em->getRepository('ClassUserBundle:Message')->find($msgId);

        $msg->setState('Read');
        $em->flush();
        return new JsonResponse(array(
            'message' => 'Marked As Read'
        ));
    }
  

}
