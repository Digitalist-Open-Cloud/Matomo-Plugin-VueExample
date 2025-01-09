# Matomo VueExample Plugin

Step by step guide to do a Matomo plugin using Vue.js

- ./console generate:plugin

Give the plugin a name, description, version

```sh
./console generate:plugin
Enter a plugin name: VueExample
Enter a plugin description: Example for VUE in Matomo
Enter a plugin version number (default to 0.1.0):
```

- ./console generate:vue-component

Give the plugin name, and name of Vue component

```sh
./console generate:vue-component
Enter the name of your plugin: VueExample
Enter the name of the component you want to create: TestVue
```

Create a controller, this is used for content

```sh
./console generate:controller
Enter the name of your plugin: VueExample
```

This creates the controller and the template (`templates/index.twig`)

Edit controller

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

```php
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

Now we need a translations for the Menu item (`VueExample_MyVueExample`).

Create a folder called lang in the plugin folder (`VueExample/lang`).
Create a file called en.json (this is for english, default language).
Add to file:

```json
{
  "VueExample": {
      "MyVueExample": "My Vue example"
  }
}
```

Build the vue component:

```sh
./console vue:build VueExample
```

You could also build the component continuously, with `--watch` if you are using more than one terminal session.

```sh
./console vue:build VueExample --watch
```

## Activate plugin

./console plugin:activate VueExample

## See plugin in action

Go to Administration (cog wheel) -> Platform -> My vue example.
Click the `+` sign until you reach 16, you should get an alert.

## Add dynamic content to Vue component

From our twig template we can add content to the Vue component.

Edit `templates/index.twig`

Add a heading attribute to the div with the vue component:

```php
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

```sh
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
content-title="{{ 'VueExample_MyTitle'|translate }}">
```

Now you should have a translatable prop for your vue component that you could add dynamically in your twig template.

