<?php

namespace Jhekasoft\Bundle\RegistrationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', array(
            'attr' => array('class' => 'form-control'),
        ));
        $builder->add('name', 'text', array(
            'attr' => array('class' => 'form-control'),
        ));
        $builder->add('password', 'repeated', array(
            'first_name'  => 'password',
            'second_name' => 'confirm',
            'type'        => 'password',
            'first_options' => array('attr' => array('class' => 'form-control')),
            'second_options' => array('attr' => array('class' => 'form-control')),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jhekasoft\Bundle\RegistrationBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'user';
    }
}