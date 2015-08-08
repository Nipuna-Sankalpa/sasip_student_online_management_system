<?php

namespace Sasip\ClassUserBundle\Entity;

use Sasip\UserBundle\Entity\Person;

class Student extends Person {

    private $firstName;
    private $lastName;
    private $id;
    private $address;
    private $school;
    private $year_of_exam;

    function getFirstName() {
        return $this->firstName;
    }

    function getLastName() {
        return $this->lastName;
    }

    function getId() {
        return $this->id;
    }

    function getAddress() {
        return $this->address;
    }

    function getSchool() {
        return $this->school;
    }

    function getYear_of_exam() {
        return $this->year_of_exam;
    }

    function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setSchool($school) {
        $this->school = $school;
    }

    function setYear_of_exam($year_of_exam) {
        $this->year_of_exam = $year_of_exam;
    }

}
