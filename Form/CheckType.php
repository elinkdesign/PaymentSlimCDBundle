<?php

namespace eLink\Payment\SlimCDBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraints as Assert;

class CheckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('checkNumber', 'text', array(
                'required' => false,
                'label' => 'Check Number',
                'error_bubbling' => true
            ))
        ;
    }

    public function getName()
    {
        return 'check';
    }
}