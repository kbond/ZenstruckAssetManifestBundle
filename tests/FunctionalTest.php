<?php

namespace Zenstruck\AssetManifestBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class FunctionalTest extends WebTestCase
{
    public function test_default_config()
    {
        $client = self::createClient();
        $client->request('GET', '/test?asset=foo/bar/baz.css');

        $this->assertSame('/foo/bar/baz.css', trim($client->getResponse()->getContent()));
    }

    public function test_manifest_file()
    {
        $client = self::createClient(['environment' => 'manifest']);
        $client->request('GET', '/test?asset=foo/bar/baz.css');

        $this->assertSame('/path/to/build.css', trim($client->getResponse()->getContent()));
    }

    public function test_manifest_fallback()
    {
        $client = self::createClient(['environment' => 'manifest']);
        $client->request('GET', '/test?asset=not/in/manifest.css');

        $this->assertSame('/not/in/manifest.css', trim($client->getResponse()->getContent()));
    }

    public function test_can_pass_asset_package()
    {
        $client = self::createClient(['environment' => 'manifest']);
        $client->request('GET', '/test?asset=foo/bar/baz.css&package=cdn');

        $this->assertSame('https://cdn.example.com/path/to/build.css', trim($client->getResponse()->getContent()));
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Manifest file "invalid file" does not exist.
     */
    public function test_invalid_manifest_file()
    {
        self::createClient(['environment' => 'invalid_manifest']);
    }
}
