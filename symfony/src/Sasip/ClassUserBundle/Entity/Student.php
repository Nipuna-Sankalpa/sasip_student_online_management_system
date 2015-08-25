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
    private $image;
    private $Mobile;
    private $dateOfBirth;
    private $gender;
    
    private $portfolio;

    function getPortfolio() {
        return $this->portfolio;
    }

    function setPortfolio($portfolio) {
        $this->portfolio = $portfolio;
    }

    function getFirstName() {
        return $this->first_name;
    }

    function getLastName() {
        return $this->last_name;
    }

    function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    function getDateOfBirth() {
        return $this->dateOfBirth;
    }

    function getGender() {
        return $this->gender;
    }

    function setDateOfBirth($dateOfBirth) {
        $this->dateOfBirth = $dateOfBirth;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function getMobile() {
        return $this->Mobile;
    }

    function setMobile($Mobile = null) {
        $this->Mobile = $Mobile;
    }

    function getImage() {
        return $this->image;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function getParentName() {
        return $this->parent_name;
    }

    function getParentMobile() {
        return $this->parent_mobile;
    }

    function setParentName($parent_name) {
        $this->parent_name = $parent_name;
    }

    function setParent_mobile($parent_mobile) {
        $this->parent_mobile = $parent_mobile;
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

    function getYearOfExam() {
        return $this->year_of_exam;
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

    function setYearOfExam($year_of_exam) {
        $this->year_of_exam = $year_of_exam;
    }

}
