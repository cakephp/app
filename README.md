# CakePHP Application Skeleton

A skeleton for creating applications with [CakePHP](http://cakephp.org) 3.0.

This is an unstable repository and should be treated as an alpha.

## Installation

### Install with git

1. Clone this repository.
2. Edit `App/Config/bootstrap.php` and uncomment the section for using
   the built-in CakePHP autoloader. Or download composer, and use `php composer.phar install`
   to download CakePHP and any other dependencies.

### Install with composer

You can install this application skeleton using composer. You'll need to install
[composer](http://getcomposer.org/doc/00-intro.md) first. After installing `composer`
you can install this project & the required dependencies using:

	php composer.phar create-project cakephp/app --dev

This will download this repository, install the CakePHP framework and testing libraries.

## Configuration

Once you've installed the dependencies copy the `App/Config/app.php.default` to `Config/app.php`.
You should edit this file and setup the 'Datasources' array to point at your database.

After creating `App/Config/app.php` you should go to the `/` route and ensure all the boxes are green.
