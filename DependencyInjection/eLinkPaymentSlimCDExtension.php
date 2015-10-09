<?php

namespace eLink\Payment\SlimCDBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class eLinkPaymentSlimCDExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->process($configuration->getConfigTreeBuilder(), $configs);

        $xmlLoader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $xmlLoader->load('services.xml');

        $container->setParameter('payment.slimcd.username', $config['slimcd_username']);
        $container->setParameter('payment.slimcd.clientid', $config['slimcd_clientid']);
        $container->setParameter('payment.slimcd.password', $config['slimcd_password']);
        $container->setParameter('payment.slimcd.siteid', $config['slimcd_siteid']);
        $container->setParameter('payment.slimcd.priceid', $config['slimcd_priceid']);
        $container->setParameter('payment.slimcd.key', $config['slimcd_key']);
        $container->setParameter('payment.slimcd.usetestaccount', $config['slimcd_usetestaccount']);
        $container->setParameter('payment.slimcd.endpoint', $config['slimcd_endpoint']);

        $container->setParameter('payment.slimcd.access_load_username', $config['slimcd_access_load_username']);
        $container->setParameter('payment.slimcd.access_load_password', $config['slimcd_access_load_password']);
        $container->setParameter('payment.slimcd.access_sale_username', $config['slimcd_access_sale_username']);
        $container->setParameter('payment.slimcd.access_sale_password', $config['slimcd_access_sale_password']);
    }
}