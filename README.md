# CakePHP Application Skeleton

A skeleton for creating applications with [CakePHP](http://cakephp.org) 3.0.

This is an unstable repository and should be treated as an alpha.

## Installation

After cloning this repository you can install CakePHP into your new application
in one of two ways:

### Install with composer

1. Download [composer](http://getcomposer.org/doc/00-intro.md).
2. Run `php composer.phar install` to install dependencies.

### Manual installation

1. Clone [CakePHP](https://github.com/cakephp/cakephp) into `vendor/cakephp/cakephp`.
2. Checkout the `3.0` branch in the new CakePHP clone.
3. In `App/Config/bootstrap.php` uncomment the section using `Cake\Core\ClassLoader`.
4. Copy `App/Config/app.default.php` to `App/Config/app.php`

You should now be able to visit the path to where you installed CakePHP and see the
setup traffic lights.

## Configuration

Read and edit `App/Config/app.php` and setup the 'Datasources' and any other configuration
relevant for your application.
