<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\PublicityUserBundle\Entity;

/**
 * Description of Feedback
 *
 * @author Flash
 */
class Feedback {

    //put your code here
    private $firstname;
    private $lastname;
    private $title;
    private $content;
    private $id;

    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getId() {
        return $this->id;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setId($id) {
        $this->id = $id;
    }


}
