<?php

namespace Zenstruck\AssetManifestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('zenstruck_asset_manifest');

        $rootNode
            ->children()
                ->scalarNode('manifest_file')
                    ->defaultNull()
                ->end()
                ->arrayNode('prefix')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('source')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('destination')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
