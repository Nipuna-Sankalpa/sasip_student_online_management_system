<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Entity;

/**
 * Description of Notification
 *
 * @author Flash
 */
class Notification {

    //put your code here

    private $id;
    private $subject;
    private $notification;
    private $timestamp;
    private $state;

    public function getId() {
        return $this->id;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getNotification() {
        return $this->notification;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getState() {
        return $this->state;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function setNotification($notification) {
        $this->notification = $notification;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function setState($state) {
        $this->state = $state;
    }

}
