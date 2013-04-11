<?php

namespace TPM\Payment\SlimCDBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TPMPaymentSlimCDExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->process($configuration, $configs);

        $xmlLoader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $xmlLoader->load('services.xml');

        $container->setParameter('payment.slimcd.clientid', $config['clientid']);
        $container->setParameter('payment.slimcd.password', $config['password']);
        $container->setParameter('payment.slimcd.siteid', $config['siteid']);
        $container->setParameter('payment.slimcd.priceid', $config['priceid']);
        $container->setParameter('payment.slimcd.key', $config['key']);
        $container->setParameter('payment.slimcd.usertestaccount', $config['usertestaccount']);
        $container->setParameter('payment.slimcd.endpoint', $config['endpoint']);
    }
}