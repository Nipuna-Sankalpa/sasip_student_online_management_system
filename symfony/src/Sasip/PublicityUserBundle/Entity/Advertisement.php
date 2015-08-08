<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\PublicityUserBundle\Entity;

/**
 * Description of Advertisement
 *
 * @author Flash
 */
class Advertisement {

    private $id;
    private $content;

    function getId() {
        return $this->id;
    }

    function getContent() {
        return $this->content;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setContent($content) {
        $this->content = $content;
    }

}
