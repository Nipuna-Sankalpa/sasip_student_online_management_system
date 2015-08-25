<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

/**
 * Description of MobileForm
 *
 * @author Flash
 */
class MobileForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('person_id', 'text', array(
                    'required' => TRUE
                ))
                ->add('contact_number', 'text', array(
                    'required' => TRUE
        ));
    }

    public function configureOption(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csfr_protection' => true,
            'csrf_field_name' => '_token',
            'data_class' => 'Sasip\ClassUserBundle\Entity\Mobile',
        ));
    }

    public function getName() {
        return 'Mobile_number';
    }

//put your code here
}
