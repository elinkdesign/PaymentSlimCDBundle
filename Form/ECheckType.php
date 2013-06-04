<?php

namespace eLink\Payment\SlimCDBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ECheckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('account_number', 'text', array('required' => true))
            ->add('routing_number', 'text', array('required' => true))
            ->add('check_number', 'text', array('required' => false)) // assign automatically if not entered?
        ;
    }

    public function getName()
    {
        return 'e_check';
    }
}