<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\PublicityUserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

/**
 * Description of FeedbackForm
 *
 * @author Flash
 */
class FeedbackForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('firstname', 'text', array(
                    'required' => true
                ))
                ->add('lastname', 'text', array(
                    'required' => true
                ))
                ->add('title', 'text', array(
                    'required' => true
                ))
                ->add('content', 'textarea', array(
                    'required' => true
        ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sasip\PublicityUserBundle\Entity\Feedback',
            'csfr_protection' => true,
            'csrf_field_name' => '_token'
        ));
    }

    public function getName() {
        return 'sasip_feedback_form';
    }

}
