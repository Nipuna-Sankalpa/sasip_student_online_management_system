<?php

namespace Sasip\ClassUserBundle\Entity;

use Sasip\UserBundle\Entity\Person;

class User extends Person {

    private $id;
    private $firstName;
    private $lastName;

    function getId() {
        return $this->id;
    }

    function getFirstName() {
        return $this->firstName;
    }

    function getLastName() {
        return $this->lastName;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    function setLastName($lastName) {
        $this->lastName = $lastName;
    }

}
