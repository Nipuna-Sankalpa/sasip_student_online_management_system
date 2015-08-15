<?php

namespace Sasip\ClassUserBundle\Entity;

class Student {

    private $first_name;
    private $last_name;
    protected $id;
    private $address;
    private $school;
    private $year_of_exam;
    private $parent_name;
    private $parent_mobile;

    function getParent_name() {
        return $this->parent_name;
    }

    function getParent_mobile() {
        return $this->parent_mobile;
    }

    function setParent_name($parent_name) {
        $this->parent_name = $parent_name;
    }

    function setParent_mobile($parent_mobile) {
        $this->parent_mobile = $parent_mobile;
    }

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
