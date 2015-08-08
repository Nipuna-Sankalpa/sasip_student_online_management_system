<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\UserBundle\Form\Type;

/**
 * Description of RegistrationFormType
 *
 * @author Flash
 */
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('id','text');
    }

    public function getParent() {
        return 'fos_user_registration';
    }

    public function getName() {
        return 'sasip_user_registration';
    }

}
