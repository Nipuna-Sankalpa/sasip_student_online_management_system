<?php

namespace Sasip\ClassUserBundle\Entity;

class Message {

    private $student_id;
    private $teacher_id;
    private $content;
    private $state;

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
