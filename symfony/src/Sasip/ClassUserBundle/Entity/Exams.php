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
    private $fees;
    private $conductDay;
    
    function getId() {
        return $this->id;
    }

    function getFees() {
        return $this->fees;
    }

    function getConductDay() {
        return $this->conductDay;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFees($fees) {
        $this->fees = $fees;
    }

    function setConductDay($conductDay) {
        $this->conductDay = $conductDay;
    }


    
}
