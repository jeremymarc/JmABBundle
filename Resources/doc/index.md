Getting started with JmABBundle
===============================

The symfony2 ABBundle provide an easy way to manage application templates which can be used for AB Testing (or not).


## Installation

### Step 1: Download JmABBundle using composer

Add JmABBundle in your composer.json:

```js
{
    "require": {
        "jm/ab-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update jm/ab-bundle
```

Composer will install the bundle to your project's `vendor/jm` directory.


### Step 2: Enable the bundle
```php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Jm\ABBundle\JmABBundle(),
    );
}
```

### Step 3: Configuration

Configure the bundle using the dic configuration file
```php
jm_ab:
    custom_loader: true
    variation: b
    cache_time: 3600
```

custom_loader:
(default value true)
Allow the bundle to override the default twig loader (FileSystemLoader) to use
Twig_Loader_Chain to chain our custom Twig Loader (TemplateLoader) and FileSystemLoader.
If the template is not found in the DB, it will look for it using the FileSystemLoader.
You can disable the loader with custom_loader: false

variation:
(default value b)
This is the default value for the variation (version B) of the page.
To switch from one version to another one, just use the variation parameter in the url :
http://url.com/?variation_parameter -> http://url.com/?b


If you want to insert the Google Analytics Content Experiment script,
just insert the {{ GAexperimentScript }} variable in the template. It
will be automatically replaced by the javascript with the Template
experiment code.

You can load a Template from a controller using TemplateManager :
$this->get('jm_ab.template_manager')->renderTemplate('name') or ;
$this->get('jm_ab.template_manager')->renderTemplate('template:name',
$vars);
Note that 'template:' and $vars are optionals.
