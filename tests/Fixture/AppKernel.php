<?php

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Zenstruck\AssetManifestBundle\ZenstruckAssetManifestBundle;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class AppKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new ZenstruckAssetManifestBundle(),
        ];
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->add('/test', 'kernel:testAction', 'test');
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $c->loadFromExtension('framework', [
            'secret' => 'Zenstruck\AssetManifestBundle',
            'test' => null,
            'assets' => [
                'packages' => [
                    'cdn' => ['base_urls' => ['https://cdn.example.com']],
                ],
            ],
        ]);

        $c->loadFromExtension('twig', [
            'paths' => ['%kernel.root_dir%' => null],
        ]);

        switch ($this->environment) {
            case 'manifest':
                $c->loadFromExtension('zenstruck_asset_manifest', [
                    'manifest_file' => '%kernel.root_dir%/manifest.json',
                ]);

                break;

            case 'invalid_manifest':
                $c->loadFromExtension('zenstruck_asset_manifest', [
                    'manifest_file' => 'invalid file',
                ]);

                break;
        }
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir().'/ZenstruckAssetManifestBundle/cache';
    }

    public function getLogDir()
    {
        return sys_get_temp_dir().'/ZenstruckAssetManifestBundle/log';
    }

    public function testAction(Request $request)
    {
        return new Response(
            $this->container->get('twig')->render('template.html.twig', [
                'asset' => $request->query->get('asset'),
                'package' => $request->query->get('package'),
            ])
        );
    }
}
