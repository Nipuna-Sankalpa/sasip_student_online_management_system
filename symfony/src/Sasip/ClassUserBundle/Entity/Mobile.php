<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Entity;

/**
 * Description of Mobile
 *
 * @author Flash
 */
class Mobile {

    private $id;
    private $personId;
    private $contactNumber;

    public function getPersonId() {
        return $this->personId;
    }

    public function getContactNumber() {
        return $this->contactNumber;
    }

    public function setPersonId($personId) {
        $this->personId = $personId;
    }

    public function setContactNumber($contactNumber) {
        $this->contactNumber = $contactNumber;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

}
