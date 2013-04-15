<?php

namespace eLink\Payment\SlimCDBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FullNameFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // normally we'll want some sort of condition here
        $form->add($this->factory->createNamed('fullName', 'text', null, array(
            'required' => false,
            'label' => 'Cardholder\'s Name',
            'validation_constraint' => new Assert\NotBlank(),
            'error_bubbling' => true
        )));
    }
}