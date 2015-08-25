<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Entity;

/**
 * Description of Exams
 *
 * @author Flash
 */
class Exams {

    private $id;
    private $fee;
    private $conductDay;
    private $time;
    private $teacher_id;
    

    public function getTime() {
        return $this->time;
    }

    public function getTeacherId() {
        return $this->teacher_id;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function setTeacherId($teacher_id) {
        $this->teacher_id = $teacher_id;
    }

    function getId() {
        return $this->id;
    }

    function getFees() {
        return $this->fee;
    }

    function getConductDay() {
        return $this->conductDay;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFees($fees) {
        $this->fee = $fees;
    }

    function setConductDay($conductDay) {
        $this->conductDay = $conductDay;
    }

}
