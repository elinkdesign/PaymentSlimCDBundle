<?php

namespace eLink\Payment\SlimCDBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CheckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('check_number', 'text', array('required' => true));
    }

    public function getName()
    {
        return 'check';
    }
}