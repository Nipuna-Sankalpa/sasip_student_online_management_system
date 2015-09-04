<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Form;

/**
 * Description of MessagesForm
 *
 * @author Flash
 */
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class MessagesForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('content', 'textarea')
                ->add('title', 'text')
                ->add('receiver', 'choice');
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csfr_protection' => true,
            'csrf_field_name' => '_token',
            'data_class' => 'Sasip\ClassUserBundle\Entity\Message',
        ));
    }

    public function getName() {
        return 'sasip_msg_form';
    }

}
