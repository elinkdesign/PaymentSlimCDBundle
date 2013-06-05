<?php

namespace eLink\Payment\SlimCDBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ECheckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('accountNumber', 'text', array(
                'required' => false,
                'label' => 'Account Number',
                'validation_constraint' => new Assert\NotBlank(),
                'error_bubbling' => true
            ))
            ->add('routingNumber', 'text', array(
                'required' => false,
                'label' => 'Routing Number',
                'validation_constraint' => new Assert\NotBlank(),
                'error_bubbling' => true
            ))
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
        return 'e_check';
    }
}