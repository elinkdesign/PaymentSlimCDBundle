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
        $config = $processor->process($configuration->getConfigTreeBuilder(), $configs);

        $xmlLoader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $xmlLoader->load('services.xml');

        $container->setParameter('payment.slimcd.clientid', $config['slimcd_clientid']);
        $container->setParameter('payment.slimcd.password', $config['slimcd_password']);
        $container->setParameter('payment.slimcd.siteid', $config['slimcd_siteid']);
        $container->setParameter('payment.slimcd.priceid', $config['slimcd_priceid']);
        $container->setParameter('payment.slimcd.key', $config['slimcd_key']);
        $container->setParameter('payment.slimcd.usertestaccount', $config['slimcd_usertestaccount']);
        $container->setParameter('payment.slimcd.endpoint', $config['slimcd_endpoint']);
    }
}