<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sasip\ClassUserBundle\Form\MobileForm;

/**
 * Description of TeacherRegisterForm
 *
 * @author Flash
 */
class TeacherRegisterForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $option) {
        $builder->add('firstName', 'text')
                ->add('lastName', 'text')
                ->add('profileImage', 'file')
                ->add('portfolio', 'textarea')
                ->add('school', 'text')
                ->add('gender', 'choice', array(
                    'placeholder' => 'Select gender',
                    'choices' => array('Male' => 'Male', 'Female' => 'Female')
                ))
                ->add('address', 'text')
                ->add('date_of_birth', 'date', array(
                    'label' => 'Date Of Birth',
                    'widget' => 'single_text',
                    'required' => TRUE,
                    'format' => 'yyyy-MM-dd'
                ))
                ->add('schoolTeach', 'text')
                ->add('mobile1', new MobileForm(), array(
                    'attr' => array('id' => 'mobile_1')
                ))
                ->add('mobile2', new MobileForm(), array(
                    'attr' => array('id' => 'mobile_2')
                ))
                ->add('university', 'text')
                ->add('linkedIn', 'text')
                ->add('twitter', 'text')
                ->add('facebook', 'text')
                ->add('title', 'text')
                ->add('salutation', 'choice', array(
                    'placeholder' => 'Select Salutation',
                    'choices' => array(
                        'Rev' => 'Rev',
                        'Prof' => 'Prof',
                        'Dr' => 'Dr',
                        'Mr' => 'Mr',
                        'Miss' => 'Miss',
                        'Mrs' => 'Mrs'
                    )
        ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csfr_protection' => true,
            'csrf_field_name' => '_token',
            'intension' => 'sasip_teacher'
        ));
    }

    public function getName() {
        return 'Teacher_form';
    }

}
