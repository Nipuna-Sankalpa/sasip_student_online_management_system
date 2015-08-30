<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Entity;

/**
 * Description of TutionClass
 *
 * @author Flash
 */
class TutionClass {

    private $conductDay;
    private $fees;
    protected $id;
    private $teacher_id;
    private $time;
    private $subject;

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getConductDay() {
        return $this->conductDay;
    }

    public function getFees() {
        return $this->fees;
    }

    public function getId() {
        return $this->id;
    }

    public function getTeacherid() {
        return $this->teacher_id;
    }

    public function getTime() {
        return $this->time;
    }

    public function setConductDay($conductDay) {
        $this->conductDay = $conductDay;
    }

    public function setFees($fees) {
        $this->fees = $fees;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTeacherid($teacher_id) {
        $this->teacher_id = $teacher_id;
    }

    public function setTime($time) {
        $this->time = $time;
    }

}
