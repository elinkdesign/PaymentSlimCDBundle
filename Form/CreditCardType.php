<?php

namespace Application\JMS\PaymentCoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreditCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('holder', 'text', array('required' => false))
            ->add('number', 'text', array('required' => false))
            ->add('expires', 'date', array('required' => false))
            ->add('code', 'text', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'slimcd_credit_card';
    }
}