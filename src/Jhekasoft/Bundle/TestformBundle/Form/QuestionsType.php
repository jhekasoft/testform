<?php

namespace Jhekasoft\Bundle\TestformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuestionsType extends AbstractType
{
    protected $questions;

    public function __construct($questions) {
        $this->questions = $questions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('answer1', 'text', array(
            'constraints' => array(new NotBlank()),
            'label' => $this->questions[1],
        ));

        $builder->add('answer2', 'text', array(
            'constraints' => array(new NotBlank()),
            'label' => $this->questions[2],
        ));

        $builder->add('answer3', 'text', array(
            'constraints' => array(new NotBlank()),
            'label' => $this->questions[3],
        ));

        $builder->add('answer4', 'text', array(
            'constraints' => array(new NotBlank()),
            'label' => $this->questions[4],
        ));

        $builder->add('answer5', 'text', array(
            'constraints' => array(new NotBlank()),
            'label' => $this->questions[5],
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
