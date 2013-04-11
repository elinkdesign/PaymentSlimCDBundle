<?php

namespace TPM\Payment\SlimCDBundle\DependencyInjection;

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
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();

        return $treeBuilder
            ->root('tpm_payment_slimcd')
                ->children()
                    ->scalarNode('slimcd_clientid')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('slimcd_password')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('slimcd_siteid')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('slimcd_priceid')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('slimcd_key')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('slimcd_usertestaccount')->defaultValue('false')->end()
                    ->scalarNode('slimcd_endpoint')->defaultValue('https://stats.slimcd.com/wswebservices/transact.asmx/PostXML')->cannotBeEmpty()->end()
                ->end()
            ->end()
            ->buildTree();
    }
}