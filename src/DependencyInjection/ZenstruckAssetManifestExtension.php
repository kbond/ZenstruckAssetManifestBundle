<?php

namespace Zenstruck\AssetManifestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class ZenstruckAssetManifestExtension extends ConfigurableExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('twig.xml');

        $manifest = [];
        $manifestFile = $mergedConfig['manifest_file'];

        if ($manifestFile !== null) {
            $manifest = $this->loadFromFile($manifestFile, $mergedConfig['prefix']['source'], $mergedConfig['prefix']['destination']);
        }

        $container->getDefinition('zenstruck_asset_manifest.twig_extension')->replaceArgument(0, $manifest);
    }

    /**
     * @param string $file
     * @param string $sourcePrefix
     * @param string $destPrefix
     *
     * @return array
     */
    private function loadFromFile($file, $sourcePrefix, $destPrefix)
    {
        if (!file_exists($file)) {
            throw new InvalidConfigurationException(sprintf('Manifest file "%s" does not exist.', $file));
        }

        $manifest = [];

        foreach (json_decode(file_get_contents($file), true) as $key => $value) {
            $manifest[$sourcePrefix.$key] = $destPrefix.$value;
        }

        return $manifest;
    }
}
