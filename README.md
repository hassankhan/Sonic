# Zepto [![Latest Stable Version](https://poser.pugx.org/hassankhan/zepto/v/stable.png)](https://packagist.org/packages/hassankhan/zepto) [![Total Downloads](https://poser.pugx.org/hassankhan/zepto/downloads.png)](https://packagist.org/packages/hassankhan/zepto) [![Latest Unstable Version](https://poser.pugx.org/hassankhan/zepto/v/unstable.png)](https://packagist.org/packages/hassankhan/zepto) [![License](https://poser.pugx.org/hassankhan/zepto/license.png)](https://packagist.org/packages/hassankhan/zepto)

Master: [![Build Status](https://travis-ci.org/hassankhan/Zepto.png?branch=master)](https://travis-ci.org/hassankhan/Zepto) [![Coverage Status](https://coveralls.io/repos/hassankhan/Zepto/badge.png?branch=master)](https://coveralls.io/r/hassankhan/Zepto?branch=master)

Develop: [![Build Status](https://travis-ci.org/hassankhan/Zepto.png?branch=develop)](https://travis-ci.org/hassankhan/Zepto) [![Coverage Status](https://coveralls.io/repos/hassankhan/Zepto/badge.png?branch=develop)](https://coveralls.io/r/hassankhan/Zepto?branch=develop)

Zepto is a stupidly simple, blazing fast, flat-file CMS based on [Pico](http://pico.dev7studios.com).

Zepto is a flat-file CMS - this means there is no administration backend and database to deal with. You simply create ``.md`` files in the "content" folder and that becomes a page.

Its interface is _supposed_ to be simple and is in process of documentation. Thank you for choosing Zepto for your next project.

## Features

* Uses Markdown for content
* Uses a powerful(ish) [Slim](http://slimframework.com/)/[Silex](http://silex.sensiolabs.org/)-style router
    * Standard and custom HTTP methods
    * Route parameters with wildcards and conditions
* Dependency injection container using [Pimple]()
* Template rendering using [Twig]()
* HTTP caching
* Error handling and debugging
* Application hooks and extensible components for extending functionality
* Simple configuration
* Hilarious, snarky source code comments

## Getting Started

### Install

#### Composer install
    composer create-project hassankhan/zepto

Then add the following to the top of your ``index.php`` file:

    <?php
    require 'vendor/autoload.php';

#### Manual install

***Coming soon***

### System Requirements

You need **PHP >= 5.3.0**.

### First Run

Instantiate a Zepto application:

    $zepto = new \Zepto\Zepto();

Run the Zepto application:

    $zepto->run();

### Setup your web server

#### Apache

Ensure the `.htaccess` and `index.php` files are in the same public-accessible directory. The `.htaccess` file should at the very minimum contain this code:

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [QSA,L]

#### Others

Zepto hasn't been tested on other configurations yet, but because of how similar it is to [Slim](), the same instructions should work.

## Documentation

You can check out more in-depth documentation [here](https://github.com/hassankhan/Zepto/wiki/Documentation).

## How to Contribute

### Pull Requests

1. Fork the Zepto repository
2. Create a new branch for each feature or improvement
3. Send a pull request from each feature branch to the **develop** branch

It is very important to separate new features or improvements into separate feature branches, and to send a pull request for each branch. This allows me to review and pull in new features or improvements individually.

### Style Guide

***Coming soon***

### Unit Testing

All pull requests should ideally be accompanied by passing unit tests and complete code coverage. Zepto uses [PHPUnit](https://github.com/sebastianbergmann/phpunit/) for testing.

## Community

### Forum and Knowledgebase

**Coming soon**

### Twitter

**Coming soon**

## Author

Zepto is created and maintained by [Hassan Khan](http://hassankhan.me).

## License

Zepto is released under the MIT public license.
