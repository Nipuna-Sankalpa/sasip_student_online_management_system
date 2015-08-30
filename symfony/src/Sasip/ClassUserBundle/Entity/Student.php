<?php

namespace Sasip\ClassUserBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

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
    private $mobile;
    private $date_of_birth;
    private $gender;
    private $profileImage;
    private $imagePath;

    public function getProfileImage() {
        return $this->profileImage;
        
    }

    public function setProfileImage(UploadedFile $profileimage = null) {
        $this->profileImage = $profileimage;
    }

    public function setWebPath($userName) {
        $this->imagePath = 'uploads/profileImages/student'. $userName;
    }

    public function getWebPath() {
        return $this->imagePath;
    }

    public function getAbsPath() {
        return __DIR__ . '/../../../../web/' . $this->getWebPath();
    }

    public function upload() {
        if (NULL === $this->getProfileImage()) {
            return null;
        }

        $fileName = $this->getProfileImage()->getClientOriginalName();
        $this->getProfileImage()->move($this->getAbsPath(), $fileName);
        $this->setImage($this->getWebPath().'/'.$fileName);
        
        $this->setProfileImage();
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function setMobile($mobile) {
        $this->mobile = $mobile;
    }

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
        return $this->date_of_birth;
    }

    function getGender() {
        return $this->gender;
    }

    function setDateOfBirth($dateOfBirth) {
        $this->date_of_birth = $dateOfBirth;
    }

    function setGender($gender) {
        $this->gender = $gender;
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

    function setParentMobile($parent_mobile) {
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
