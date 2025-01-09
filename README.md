# Matomo VueExample Plugin

Step by step guide to do a Matomo plugin using Vue.js and the terminal.
I wrote this to learn how to use Vue.js with Matomo in a good way, and I hope it could be useful for anyone else that is creating plugins for Matomo.

If any issues with this tutorial, please create an issue in this repo.

## Requirements

A working Matomo dev environment, with Node version 16 and at least PHP 8.2.

## Tutorial

```shell
./console generate:plugin
```

Give the plugin a name, description, version

```shell
./console generate:plugin
Enter a plugin name: VueExample
Enter a plugin description: Example for VUE in Matomo
Enter a plugin version number (default to 0.1.0):
```

edit `VueExample.php`

Remove the functions, so you now just have:

```php
class VueExample extends \Piwik\Plugin
{

}
```

```shell
./console generate:vue-component
```

Give the plugin name, and name of Vue component

```shell
Enter the name of your plugin: VueExample
Enter the name of the component you want to create: TestVue
```

Create a controller, this is used for content or any endpoint returning "something".

```shell
./console generate:controller
Enter the name of your plugin: VueExample
```

This creates both the controller and the twig template (`templates/index.twig`). The Twig templated is used for rendering the content.

Edit `controller.php`

In top, after namespace declaration, add:

```php
use Piwik\Piwik;
use Piwik\Menu\MenuAdmin;
use Piwik\Menu\MenuTop;
```

Replace the whole `public function index()`, with:

```php
    public function index()
    {
        Piwik::checkUserHasSomeAdminAccess();
        return $this->renderTemplate('index', [
            'topMenu' => MenuTop::getInstance()->getMenu(),
            'adminMenu' => MenuAdmin::getInstance()->getMenu(),
            'answerToLife' => 42
        ]);
    }
```

Edit templates/index.twig

Remove: `{% extends 'dashboard.twig' %}`
Set: `{% extends 'admin.twig' %}`

Before `{% endblock %}`, add:

```html
<div vue-entry="VueExample.TestVue"></div>
```

Create a menu

```sh
./console generate:menu
Enter the name of your plugin: VueExample
```

Edit `Menu.php`

In function `configureAdminMenu`, add:

```php
 $menu->addPlatformItem('VueExample_MyVueExample', $this->urlForDefaultAction(), $orderId = 30);
```

Now we need a translation for the Menu item (`VueExample_MyVueExample`).

Create a folder called `lang` in the plugin folder (`VueExample/lang`).
Create a file called `en.json` (this is for english, default language).
Add to file:

```json
{
  "VueExample": {
      "MyVueExample": "My Vue example"
  }
}
```

Build the vue component:

```shell
./console vue:build VueExample
```

You could also build the component continuously, with `--watch` if you are using more than one terminal session and are adding changes to the component.

```shell
./console vue:build VueExample --watch
```

## Activate plugin

```shell
./console plugin:activate VueExample
```

## See plugin in action

Go to Administration (cog wheel) -> Platform -> My vue example.
Click the `+` sign until you reach 16, you should get an alert.

## Add dynamic content to Vue component

From our twig template we can add content to the Vue component.

Edit `templates/index.twig`

Add a custom content-title attribute to the div with the vue component:

```html
 <div vue-entry="VueExample.TestVue" content-title="My Title"></div>
 ```

Edit `vue/src/TestVue/TestVue.vue`

In `export default defineComponent` add props:

```javascript
export default defineComponent({
  props: {
    contentTitle: String,
  },
```

The attribute `content-title` becomes `contentTitle` in the vue component.

After `<template>`, add our new prop:

```javascript
<h3>{{ contentTitle }}</h3>
```

Make sure you generate your component (if you are not running `--watch`):

```shell
./console vue:build VueExample
```

You could also use a translatable title, add it to `lang/en.json`:

```json
{
  "VueExample": {
      "MyVueExample": "My Vue example",
      "MyTitle": "My Title"
  }
}
```

Edit `templates/index.twig`

Set title with translation:

```php
content-title="{{ 'VueExample_MyTitle'|translate }}"
```

Now you should have a translatable prop for your vue component that you could add dynamically in your twig template.

## Vue component translatable strings

Bute even better, you can translatable strings direct in the vue component, but you need to add the translatable string to javascript.

Edit `VueExample.php`

Add these two functions:

```php
    public function registerEvents()
    {
        $events = [
            'Translate.getClientSideTranslationKeys' => 'getTranslations',
        ];
        return $events;
    }

    public function getTranslations(&$translations)
    {
        $translations[] = 'VueExample_MyTitleTooltip';
    }
```

Matomo have a hook-system, and the events you are registering n your plugin, as in this case, `'Translate.getClientSideTranslationKeys` - you can hook into with your own function, in this case `getTranslations`, and you are adding your own translations in the `$translations` array.

Edit `vue/src/TestVue/TestVue.vue`

Add:

```php
<h3 :title="translate('VueExample_MyTitleTooltip')">{{ contentTitle }}</h3>
```

`:title` adds the title attribute to the generated HTML.
