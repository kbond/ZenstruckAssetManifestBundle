<?php

namespace Zenstruck\AssetManifestBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Zenstruck\AssetManifestBundle\DependencyInjection\Compiler\ParseManifestCompilerPass;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class ZenstruckAssetManifestBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ParseManifestCompilerPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }
}
