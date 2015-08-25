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
    private $person_id;
    private $contact_number;

    public function getId() {
        return $this->id;
    }

    public function getPerson_id() {
        return $this->person_id;
    }

    public function getContact_number() {
        return $this->contact_number;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setPerson_id($person_id) {
        $this->person_id = $person_id;
    }

    public function setContact_number($contact_number) {
        $this->contact_number = $contact_number;
    }

}
