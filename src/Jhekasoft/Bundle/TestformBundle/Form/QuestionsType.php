<?php

namespace Jhekasoft\Bundle\TestformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('answer1', 'text', array(
            'constraints' => array(new NotBlank()),
        ));

        $builder->add('answer2', 'text', array(
            'constraints' => array(new NotBlank()),
        ));

        $builder->add('answer3', 'text', array(
            'constraints' => array(new NotBlank()),
        ));

        $builder->add('answer4', 'text', array(
            'constraints' => array(new NotBlank()),
        ));

        $builder->add('answer5', 'text', array(
            'constraints' => array(new NotBlank()),
        ));

        $builder->add('submit', 'submit', array(
            'label' => 'Save',
        ));
    }

    public function getName()
    {
        return 'questions';
    }
}
