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
 * Description of NotificationForm
 *
 * @author Flash
 */
class NotificationForm extends AbstractType {

    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('subject', 'text', array(
                    'required' => TRUE
                ))
                ->add('notification', 'textarea', array(
                    'required' => true
        ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csfr_protection' => true,
            'csrf_field_name' => '_token',
            'data_class' => 'Sasip\ClassUserBundle\Entity\Notification',
        ));
    }

    public function getName() {
        return sasip_notification_form;
    }

}
