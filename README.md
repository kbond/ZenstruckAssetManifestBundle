**NOTE**: This functionality of this bundle is now in [Symfony Core](https://symfony.com/doc/4.0/frontend/encore/versioning.html#loading-assets-from-the-manifest-json-file).

# ZenstruckAssetManifestBundle

[![Build Status](http://img.shields.io/travis/kbond/ZenstruckAssetManifestBundle.svg?style=flat-square)](https://travis-ci.org/kbond/ZenstruckAssetManifestBundle)
[![Scrutinizer Code Quality](http://img.shields.io/scrutinizer/g/kbond/ZenstruckAssetManifestBundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/kbond/ZenstruckAssetManifestBundle/)
[![Code Coverage](http://img.shields.io/scrutinizer/coverage/g/kbond/ZenstruckAssetManifestBundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/kbond/ZenstruckAssetManifestBundle/)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/b6b71c60-69f0-4e83-9900-bfd30621cb94.svg?style=flat-square)](https://insight.sensiolabs.com/projects/b6b71c60-69f0-4e83-9900-bfd30621cb94)
[![StyleCI](https://styleci.io/repos/56626101/shield)](https://styleci.io/repos/56626101)
[![Latest Stable Version](http://img.shields.io/packagist/v/zenstruck/asset-manifest-bundle.svg?style=flat-square)](https://packagist.org/packages/zenstruck/asset-manifest-bundle)
[![License](http://img.shields.io/packagist/l/zenstruck/asset-manifest-bundle.svg?style=flat-square)](https://packagist.org/packages/zenstruck/asset-manifest-bundle)

This bundle adds the twig function `manifest_asset` that is a wrapper for the native `asset`
but looks for a configured manifest json file to map assets. This file can be generated using
[Gulp](http://gulpjs.com) and the [gulp-rev](https://github.com/sindresorhus/gulp-rev) Gulp plugin.
If you have used [Laravel](https://laravel.com/) with [Laravel Elixir](https://github.com/laravel/elixir)
the `manifest_asset` function is similar to Laravel's `elixir` function.

## Installation

Download:

```
composer require zenstruck/asset-manifest-bundle
```

Enabled bundle:

```php
//app/AppKernel.php
//...
  public function registerBundles() {
      $bundles = [
          //...
          new Zenstruck\AssetManifestBundle\ZenstruckAssetManifestBundle(),
          //...
      ];
      //...
  }
//...
```

## Configuration

By default, no manifest is configured. In development, this is probably ideal. For production,
you will want to configure a manifest file to map your assets.

```yaml
#app/config/config_prod.yml
#...

zenstruck_asset_manifest:
    manifest_file: "%kernel.root_dir%/../web/assets/manifest.json"

#...
```

## Usage

`asset` should be replaced by `manifest_asset` in twig files.

Here an example:

```html
<!DOCTYPE html>
<html>
  <head>
    <title>My page title</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ manifest_asset('assets/main.css') }}">
  </head>
  <body>
    My page content
  </body>
</html>
```

**Note**: If no manifest file is configured, the `manifest_asset` behaves exactly like the native
`asset` function.

### Prefixes

Say your public (web) folder looks as follows:

```
.
├── assets
│   ├── build
│   │   ├── css
│   │   │   └── app-8f07f52635.css
│   │   └── rev-manifest.json
│   └── css
│       └── app.css
```

And your `rev-manifest.json` file looks as follows:

```json
{
    "css/app.css": "css/app-8f07f52635.css"
}
```

Using the `manifest_asset` twig function, you would pass `assets/css/app.css` but this wouldn't map
correctly. To fix this, you can add prefixes to your `config.yml`:

```yaml
zenstruck_asset_manifest:
    manifest_file: "%kernel.root_dir%/../web/assets/build/manifest.json"
    prefix:
        source: assets/
        destination: assets/build/
```

Now, `assets/css/app.css` would properly map to `assets/build/css/app-8f07f52635.css`.

## Full Default Config

```yaml
zenstruck_asset_manifest:
    manifest_file: ~
    prefix:
        source: ~
        destination: ~
```
