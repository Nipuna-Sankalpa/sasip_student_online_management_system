<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sasip\ClassUserBundle\Form\NotificationForm;
use Sasip\ClassUserBundle\Entity\Notification;

/**
 * Description of NotificationController
 *
 * @author Flash
 */
class NotificationController extends Controller {

    //this method will check, whether the notifications are being posted
    //check in the notification asset method
    public function checkNotifications($userId) {

        $conn = $this->getDoctrine()->getConnection();
        $query = 'SELECT status from notification_asset where user_id= :userId';

        $stmt = $conn->prepare($query);
        $stmt->execute(array(
            'userId' => $userId
        ));
        $result = $stmt->fetchAll();
        if ($result) {
            return $result[0]['status'];
        } else {
            return null;
        }
    }

//read notification from data base
    public function readNotification($userId) {

        if ($this->checkNotifications($userId)) {
            $conn = $this->getDoctrine()->getConnection();
            $query = "SELECT * from notification where status='true' ";

            $stmt = $conn->prepare($query);
            $stmt->execute(array(
                'userId' => $userId
            ));
            $result = $stmt->fetchAll();
            return $result;
        } else {
            return null;
        }
    }

    //post notification
    //store notification in data base
    public function postNotificationAction(Request $request) {
        $notificaiton = new Notification();
        $form = $this->createForm(new NotificationForm(), $notificaiton);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $notificaiton->setState(false);
            $notificaiton->setTimestamp(new \DateTime('now'));

            $em->persist($notificaiton);
            $em->flush();
            return new JsonResponse(array(
                'message' => 'Notification Posted'
            ));
        } else {
            new JsonResponse(array(
                'message' => 'ERROR'
            ));
        }
    }

}
