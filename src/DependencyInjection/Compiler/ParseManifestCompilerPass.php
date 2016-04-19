<?php

namespace Zenstruck\AssetManifestBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class ParseManifestCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $manifest = [];
        $manifestFile = $container->getParameter('zenstruck_asset_manifest.manifest_file');

        if ($manifestFile !== null) {
            $manifest = $this->loadFromFile($manifestFile);
        }

        $container->getDefinition('zenstruck_asset_manifest.twig_extension')->replaceArgument(0, $manifest);
    }

    /**
     * @param string $file
     *
     * @return array
     */
    private function loadFromFile($file)
    {
        if (!file_exists($file)) {
            throw new InvalidConfigurationException(sprintf('Manifest file "%s" does not exist.', $file));
        }

        return json_decode(file_get_contents($file), true);
    }
}
