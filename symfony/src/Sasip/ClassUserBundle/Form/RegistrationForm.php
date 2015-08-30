<?php

namespace Sasip\ClassUserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Sasip\ClassUserBundle\Form\MobileForm;

class RegistrationForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $option) {
        $builder->add('first_name', 'text', array(
                    'label' => 'First Name',
                    'required' => TRUE,
                ))
                ->add('last_name', 'text', array(
                    'label' => 'Last Name',
                    'required' => TRUE,
                ))
                ->add('profileImage', 'file')
                ->add('school', 'text', array(
                    'label' => 'School',
                    'required' => TRUE,
                ))
                ->add('year_of_exam', 'integer', array(
                    'label' => 'Year Of Exam',
                    'required' => TRUE,
                ))
                ->add('date_of_birth', 'date', array(
                    'label' => 'Date Of Birth',
                    'widget' => 'single_text',
                    'required' => TRUE,
                    'format' => 'yyyy-MM-dd'
                ))
                ->add('gender', 'choice', array(
                    'choices' => array('male' => 'Male', 'female' => 'Female'),
                    'required' => true,
                    'multiple' => false,
                ))
                ->add('mobile', new MobileForm(), array(
                    'label' => 'Contact Number'
                ))
                ->add('parent_name', 'text', array(
                    'label' => 'Name Of Guardian',
                    'required' => TRUE,
                ))
                ->add('parent_mobile', 'text', array(
                    'label' => 'Contact Details',
                    'required' => TRUE,
                ))
                ->add('portfolio', 'textarea', array(
                    'label' => 'Portfolio',
                ))
                ->add('address', 'text', array(
                    'label' => 'Address',
                    'required' => TRUE,
        ));
    }

//    data class was being removed because this class can be used for all kind of role registration
//    e:g: teacher,student,staff

    public function configureOption(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csfr_protection' => true,
            'csrf_field_name' => '_token',
            'intension' => 'sasip_student'
        ));
    }

    public function getName() {
        return 'sasip_registration_form';
    }

}
