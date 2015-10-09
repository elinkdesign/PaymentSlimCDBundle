<?php

namespace eLink\Payment\SlimCDBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        return $treeBuilder
            ->root('payment_slimcd')
                ->children()
                    ->scalarNode('slimcd_clientid')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('slimcd_password')->end()
                    ->scalarNode('slimcd_siteid')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('slimcd_priceid')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('slimcd_key')->end()
                    ->booleanNode('slimcd_usetestaccount')->defaultValue('%kernel_debug%')->end()
                    ->scalarNode('slimcd_endpoint')->defaultValue('https://trans.slimcd.com/soft/json/jsonpayment.asp')->cannotBeEmpty()->end()
                    ->scalarNode('slimcd_access_load_username')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('slimcd_access_load_password')->isRequired()->end()
                    ->scalarNode('slimcd_access_sale_username')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('slimcd_access_sale_password')->isRequired()->end()
                ->end()
            ->end()
            ->buildTree();
    }
}