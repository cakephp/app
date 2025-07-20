# CakePHP Application Demo Project

## What is this?

This is a demo project for CakePHP, showcasing the framework's features and capabilities.
It is NOT intended for production use, but rather a learning tool for new and existing CakePHP developers.

## Get started

The basic setup is all the same as mentioned in the [main branch](https://github.com/cakephp/app).
So make sure you have everything running and then continue with the following steps.

## Configuration

Read and edit the environment specific `config/app_local.php` and set up the
`'Datasources'` and any other configuration relevant for your application.

In our case the easiest way to get started is to use a SQLite database via
```php
'Datasources' => [
    'default' => [
        'url' => 'sqlite://127.0.0.1/tmp/myapp.sqlite',
    ],
]
```

Make sure the default homepage shows, that it can connect to the database.

## Migrate, Seed & Bake

This branch of the app template contains a migration file, which generates a bunch of tables and fields.

To apply the migrations, run the following command:

```bash
bin/cake migrations migrate
```

Next we need to fill the database with some fake data:

```bash
bin/cake migrations seed --seed TestSeeder
```

After that you should bake all the code:

```bash
bin/cake bake all --everything
```

This should now result in many new files in the `src/` and `templates/` directory.

To have an easier time getting to each area of the application, you can add the following to the
`templates/layout/default.ctp` file inside the `<nav>` section:

```php
<div class="top-nav-links">
    <?= $this->Html->link('Comments', ['controller' => 'Comments', 'action' => 'index']) ?>
    <?= $this->Html->link('Posts', ['controller' => 'Posts', 'action' => 'index']) ?>
    <?= $this->Html->link('Profiles', ['controller' => 'Profiles', 'action' => 'index']) ?>
    <?= $this->Html->link('Tags', ['controller' => 'Tags', 'action' => 'index']) ?>
    <?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index']) ?>
    <?= $this->Html->link('Docs', 'https://book.cakephp.org/5/', ['target' => '_blank', 'rel' => 'noopener']) ?>
    <?= $this->Html->link('Api', 'https://api.cakephp.org/', ['target' => '_blank', 'rel' => 'noopener']) ?>
</div>
```
