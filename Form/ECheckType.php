<?php

namespace eLink\Payment\SlimCDBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ECheckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('accountNumber', 'text', array('required' => false))
            ->add('routingNumber', 'text', array('required' => false))
            ->add('checkNumber', 'text', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'e_check';
    }
}