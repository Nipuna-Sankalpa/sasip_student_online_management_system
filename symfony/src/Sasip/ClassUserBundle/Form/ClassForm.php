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
 * Description of ClassForm
 *
 * @author Flash
 */
class ClassForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('id', 'text')
                ->add('fees', 'integer')
                ->add('time', 'time', array(
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'placeholder' => 'Select time',
                    
                ))
                ->add('conductDay', 'choice', array(
                    'choices' => array(
                        'monday' => 'Monday',
                        'tuesday' => 'Tuesday',
                        'wednesday' => 'Wednesday',
                        'thursday' => 'Thursday',
                        'friday' => 'Friday',
                        'saturday' => 'Saturday',
                        'sunday' => 'Sunday'
                    ),
        ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csfr_protection' => true,
            'csrf_field_name' => '_token',
            'data_class' => 'Sasip\ClassUserBundle\Entity\TutionClass'
        ));
    }

    public function getName() {
        return "Sasip_class_form";
    }

}
