<?php

namespace TPM\Payment\SlimCDBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreditCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('holder', 'text', array('required' => false))
            ->add('number', 'text', array('required' => false))
            ->add('expires', 'date', array(
                'required' => false,
                'label' => 'Expiration Date',
                'widget' => 'single_text',
            ))
            ->add('code', 'text', array('required' => false))

            'value'   => new \DateTime('now'),
                'type'    => 'date',
                'validation' => new Assert\Date(),
                'options' => array(
                    'label' => 'To',
                    'widget' => 'single_text',
                    'error_bubbling' => true
                ),
        ;
    }

    public function getName()
    {
        return 'slimcd_credit_card';
    }
}