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
    private $id;
    
    function getConductDay() {
        return $this->conductDay;
    }

    function getFees() {
        return $this->fees;
    }

    function getId() {
        return $this->id;
    }

    function setConductDay($conductDay) {
        $this->conductDay = $conductDay;
    }

    function setFees($fees) {
        $this->fees = $fees;
    }

    function setId($id) {
        $this->id = $id;
    }


}
