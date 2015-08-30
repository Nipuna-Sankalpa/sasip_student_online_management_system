<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Description of Teacher
 *
 * @author Flash
 */
class Teacher {

    protected $id;
    private $firstName;
    private $lastName;
    private $image;
    private $portfolio;
    private $profileImage;
    private $mobile1;
    private $mobile2;
    private $university;
    private $linkedIn;
    private $twitter;
    private $facebook;
    private $title;
    private $salutation;
    private $date_of_birth;
    private $gender;
    private $address;
    private $school;
    private $schoolTeach;
    private $path;

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getImage() {
        return $this->image;
    }

    public function getPortfolio() {
        return $this->portfolio;
    }

    public function getProfileImage() {
        return $this->profileImage;
    }

    public function getMobile1() {
        return $this->mobile1;
    }

    public function getMobile2() {
        return $this->mobile2;
    }

    public function getUniversity() {
        return $this->university;
    }

    public function getLinkedIn() {
        return $this->linkedIn;
    }

    public function getTwitter() {
        return $this->twitter;
    }

    public function getFacebook() {
        return $this->facebook;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getSalutation() {
        return $this->salutation;
    }

    function getDateOfBirth() {
        return $this->date_of_birth;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getSchool() {
        return $this->school;
    }

    public function getSchoolTeach() {
        return $this->schoolTeach;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setPortfolio($portfolio) {
        $this->portfolio = $portfolio;
    }

    public function setProfileImage(UploadedFile $profileImage = null) {
        $this->profileImage = $profileImage;
    }

    public function setMobile1($mobile1) {
        $this->mobile1 = $mobile1;
    }

    public function setMobile2($mobile2) {
        $this->mobile2 = $mobile2;
    }

    public function setUniversity($university) {
        $this->university = $university;
    }

    public function setLinkedIn($linkedIn) {
        $this->linkedIn = $linkedIn;
    }

    public function setTwitter($twitter) {
        $this->twitter = $twitter;
    }

    public function setFacebook($facebook) {
        $this->facebook = $facebook;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setSalutation($salutation) {
        $this->salutation = $salutation;
    }

     function setDateOfBirth($dateOfBirth) {
        $this->date_of_birth = $dateOfBirth;
    }


    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function setSchool($school) {
        $this->school = $school;
    }

    public function setSchoolTeach($schoolTeach) {
        $this->schoolTeach = $schoolTeach;
    }

    public function getWebPath() {
        return $this->path;
    }

    public function setWebPath($userId) {
        $this->path = '/uploads/profileImages/teacher/' . $userId;
    }

    public function getAbsPath() {
        return __DIR__ . '/../../../../web' . $this->getWebPath();
    }

    public function upload() {
        if ($this->getProfileImage() === null) {
            return null;
        }
        $fileName = $this->getProfileImage()->getClientOriginalName();
        $this->getProfileImage()->move($this->getAbsPath(), $fileName);
        $this->setImage($this->getWebPath() . '/' . $fileName);
        $this->setProfileImage();
    }

}
