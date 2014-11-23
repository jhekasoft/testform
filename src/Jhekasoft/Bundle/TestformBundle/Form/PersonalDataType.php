<?php

namespace Jhekasoft\Bundle\TestformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class PersonalDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', 'text', array(
            'constraints' => array(new NotBlank()),
        ));

        $builder->add('lastname', 'text', array(
            'constraints' => array(new NotBlank()),
        ));

        $builder->add('email', 'text', array(
            'constraints' => array(new NotBlank(), new Email()),
        ));

        $years = array();
        $now = new \DateTime();
        for ($i = (int) $now->format('Y'); $i >= 1900 ; $i--) {
            $years[] = $i;
        }

        $builder->add('birthdayDate', 'date', array(
            'input'  => 'datetime',
            'widget' => 'choice',
            'years'  => $years,
            'attr' => array('class' => 'form-element'),
        ));

        $builder->add('shoeSize', 'text', array(
            'constraints' => array(new NotBlank()),
        ));

        $builder->add('submit', 'submit', array(
            'label' => 'Save',
        ));
    }

    public function getName()
    {
        return 'personal_data';
    }
}
