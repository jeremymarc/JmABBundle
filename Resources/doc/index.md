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
    variation: b
    cache_time: 3600
```

##### variation: (default value b)
This is the default value for the variation (version B) of the page.
To switch from one version to another one, just use the variation parameter in the url :
```html
http://url.com/?variation_parameter -> http://url.com/?b
```

If you want to insert the Google Analytics Content Experiment script (for AB
Testing), just insert the {{ GAexperimentScript }} variable in the template.
It will be automatically replaced by the GA JavaScripts (only if you have
specified the experiment code in the Template).

You can render Template from a controller using TemplateManager:
```php
$template = $this->get('jm_ab.template_manager')->getTemplate('name');

$this->get('jm_ab.template_manager')->renderTemplate($template);
```

or in a temaplte:

```
{{ ab_render_template(ab_template('name')) }}
```

##### cache_time (default value 3600 / 1h)

Value of the cache for Doctrine Result Cache. Default value is 1 hour.
When the doctrine cache is reset, the twig template will be automatically 
refresh (it's based on the Template's updatedAt value).

### Step 4 : Admin Generator

If you are using SonataAdminBundle, the Bundle is coming with the configuration files 
to manage your Templates.