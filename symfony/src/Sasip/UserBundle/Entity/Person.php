<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;

class Person extends BaseUser {

    protected $id;
    private $role;

    public function getRole() {
        return $this->role;
    }

    //this method will call setRoles and 
    //add convert $role in to array elements and send it in to setRoles() method

    public function setRole($role) {
        $this->setRoles(array($role));
    }

    public function __construct() {
        parent::__construct();
        // your own logic
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

}
