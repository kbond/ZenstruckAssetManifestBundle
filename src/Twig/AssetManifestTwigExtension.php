<?php

namespace Zenstruck\AssetManifestBundle\Twig;

use Symfony\Bridge\Twig\Extension\AssetExtension;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class AssetManifestTwigExtension extends \Twig_Extension
{
    private $assetMap;

    public function __construct(array $assetMap)
    {
        $this->assetMap = $assetMap;
    }

    /**
     * @param \Twig_Environment $twig
     * @param string            $path
     * @param string            $packageName
     *
     * @return string
     */
    public function getAssetUrl(\Twig_Environment $twig, $path, $packageName = null)
    {
        /** @var AssetExtension $asset */
        $asset = $twig->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension');

        if (isset($this->assetMap[$path])) {
            $path = $this->assetMap[$path];
        }

        return $asset->getAssetUrl($path, $packageName);
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [new \Twig_SimpleFunction('manifest_asset', [$this, 'getAssetUrl'], ['needs_environment' => true])];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'zenstruck_asset_manifest';
    }
}
