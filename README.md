# CakePHP Application Skeleton

A skeleton for creating applications with [CakePHP](http://cakephp.org) 3.0.

This is an unstable repository and should be treated as an alpha.

## Installation

### Install with composer

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project -s dev cakephp/app [app_name]`.

If Composer is installed globally, run
`composer create-project -s dev cakephp/app [app_name]`

### Manual installation

1. Clone this repository at desired location.
2. Clone [CakePHP](https://github.com/cakephp/cakephp) into `vendor/cakephp/cakephp`.
   ```
   git clone git://github.com/cakephp/cakephp.git vendor/cakephp/cakephp
   ```
3. Checkout the `3.0` branch in the new CakePHP clone.
   ```
   cd vendor/cakephp/cakephp
   git checkout -t -b 3.0 origin/3.0
   ```
4. Copy `App/Config/app.default.php` to `App/Config/app.php`

You should now be able to visit the path to where you installed the app and see
the setup traffic lights.

## Configuration

Read and edit `App/Config/app.php` and setup the 'Datasources' and any other
configuration relevant for your application.

##Keeping up to date with the latest CakePHP 3.0 changes

If you want to keep current with the latest 3.0 skeleton changes in CakePHP you can add the following to your application’s composer.json:

`"require": {
    "cakephp/app": "dev-master"
}`

Each time you run php composer.phar update you will receive the latest changes from CakePHP 3.0 alpha skeleton.
