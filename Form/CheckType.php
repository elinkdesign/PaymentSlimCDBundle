<?php

namespace eLink\Payment\SlimCDBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CheckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('checkNumber', 'text', array(
                'required' => false,
                'label' => 'Check Number',
                'validation_constraint' => new Assert\NotBlank(),
                'error_bubbling' => true
            ))
        ;
    }

    public function getName()
    {
        return 'check';
    }
}