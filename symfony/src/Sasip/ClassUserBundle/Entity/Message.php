<?php

namespace Sasip\ClassUserBundle\Entity;

class Message {

    private $student_id;
    private $teacher_id;
    private $content;
    private $state;
    private $time_sent;
    private $title;
    private $date_sent;
    private $id;
    private $sender;

    function getSender() {
        return $this->sender;
    }

    function setSender($sender) {
        $this->sender = $sender;
    }

    function getId() {
        return $this->id;
    }

    function getDateSent() {
        return $this->date_sent;
    }

    function setDateSent($dateSent) {
        $this->date_sent = $dateSent;
    }

    function getTimeSent() {
        return $this->time_sent;
    }

    function getTitle() {
        return $this->title;
    }

    function setTimeSent($timeSent) {
        $this->time_sent = $timeSent;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function getState() {
        return $this->state;
    }

    function setState($state) {
        $this->state = $state;
    }

    function getStudent_id() {
        return $this->student_id;
    }

    function getTeacher_id() {
        return $this->teacher_id;
    }

    function getContent() {
        return $this->content;
    }

    function setStudent_id($student_id) {
        $this->student_id = $student_id;
    }

    function setTeacher_id($teacher_id) {
        $this->teacher_id = $teacher_id;
    }

    function setContent($content) {
        $this->content = $content;
    }

}
