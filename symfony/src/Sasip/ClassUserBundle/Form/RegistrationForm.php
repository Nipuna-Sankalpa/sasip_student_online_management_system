<?php

namespace Sasip\ClassUserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class RegistrationForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $option) {
        $builder->add('firstName', 'text', array(
                    'label' => 'First Name',
                ))
                ->add('lastName', 'text', array(
                    'label' => 'Last Name'
                ))
                ->add('school', 'text', array(
                    'label' => 'School'
                ))
                ->add('yearOfExam' . 'integer', array(
                    'label' => 'Year Of Exam'
                ))
                ->add('birthDay', 'date', array(
                    'label' => 'Date Of Birth'
                ))
                ->add('mobile_1', 'text', array(
                    'label' => 'Contact Number'
                ))
                ->add('parentName', 'text', array(
                    'label' => 'Name Of Guardian'
                ))
                ->add('parentMobile', 'text', array(
                    'label' => 'Contact Details'
                ))
                ->add('address', 'text', array(
                    'label' => 'Address'
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
        return 'sasip_registration_from';
    }

}
