ZenstruckAssetManifestBundle
============================

Installation
------------

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

Configuration
-------------

```yaml
#app/config/config.yml
#...

zenstruck_asset_manifest:
    manifest_file: "%kernel.root_dir%/../web/assets/manifest.json"

#...
```

Usage
-----

`asset` should be replace by `manifest_asset` in twig files. 

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
