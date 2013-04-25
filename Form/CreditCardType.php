<?php

namespace eLink\Payment\SlimCDBundle\Form;

use eLink\Payment\SlimCDBundle\Form\EventListener\FullNameFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraints as Assert;


class CreditCardType extends AbstractType
{
    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->addEventSubscriber(new FullNameFieldSubscriber($builder->getFormFactory()))
            ->add('recipient', 'genemu_jqueryautocomplete_text', array(
                'route_name' => '_credit_card_ajax'
            ))
            ->add('fullName', 'text', array(
                'required' => false,
                'label' => 'Cardholder\'s Name',
                'validation_constraint' => new Assert\NotBlank(),
                'error_bubbling' => true
            ))
            ->add('ccNumber', 'text', array(
                'required' => false,
                'label' => 'Card Number',
                'max_length' => 16,
                'validation_constraint' => new Assert\NotBlank(),
                'invalid_message' => 'Please enter a %num%-digit number.',
                'invalid_message_parameters' => array('%num%' => 16),
                'error_bubbling' => true
            ))
            ->add('expires', 'date', array(
                'required' => false,
                'label' => 'Expiration Date',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'empty_value' => '',
                'validation_constraint' => new Assert\NotBlank(),
                'invalid_message' => 'Please enter a valid expiration date.',
                'error_bubbling' => true
            ))
            ->add('securityCode', 'text', array(
                'required' => false,
                'label' => 'CVV Code',
                'validation_constraint' => new Assert\NotBlank(),
                'invalid_message' => 'Please enter a valid expiration date.',
                'error_bubbling' => true
            ))
        ;

        $user = $this->securityContext->getToken()->getUser();

        if (!$user) {
            throw new AccessDeniedException(
                'No authenticated user was found.'
            );
        }

        // $factory = $builder->getFormFactory();

        // $builder->addEventListener(
        //     FormEvents::PRE_SET_DATA,
        //     function(FormEvent $event) use($user, $factory) {
        //         $form = $event->getForm();

        //         $formOptions = array(
        //             'class' => 'Application\Sonata\UserBundle\Entity\User',
        //             'multiple' => false,
        //             'expanded' => false,
        //             'property' => 'fullName',
        //             'query_builder' => function(EntityRepository $er) use ($user) {
        //                 return;
        //             },
        //         );

        //         $form->add($factory->createNamed('foo', 'entity', null, $formOptions));
        //     }
        // );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            // 'data_class'      => 'NeaceLukens\Bundle\Entity\Order', // or whatever likely implements this
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention'       => 'slimcd_credit_card',
            'validation_groups' => function(FormInterface $form) {
                // $data = $form->getData();
                // if (Entity\ORDER::TYPE_CARDHOLDER == $data->getType()) {
                //     return array('client');
                // } else {
                //     return array('firm');
                // }
            },
        ));
    }

    public function getName()
    {
        return 'slimcd_credit_card';
    }
}