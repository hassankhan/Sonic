# Zepto

``master``: [![Build Status](https://travis-ci.org/hassankhan/Zepto.png?branch=master)](https://travis-ci.org/hassankhan/Zepto) ``develop``: [![Build Status](https://travis-ci.org/hassankhan/Zepto.png?branch=develop)](https://travis-ci.org/hassankhan/Zepto)

[![Coverage Status](https://coveralls.io/repos/hassankhan/Zepto/badge.png)](https://coveralls.io/r/hassankhan/Zepto)

Zepto is a stupidly simple, blazing fast, flat-file CMS based on [Pico](http://pico.dev7studios.com) and [Slim](http://slimframework.com/).

Zepto is a flat file CMS - this means there is no administration backend and database to deal with. You simply create ``.md`` files in the "content" folder and that becomes a page. For example, this file is called ``index.md`` and is shown as the main landing page.

Its interface is _supposed_ to be simple and is in process of documentation. Thank you for choosing Zepto for your next project.

## Features

* Uses Markdown for content
* Powerful(ish) router
    * Standard and custom HTTP methods
    * Route parameters with wildcards and conditions
* Resource Locator and DI container
* Template rendering
* HTTP caching
* Error handling and debugging
* Application hooks and extensible components for extending functionality
* Simple configuration
* Hilarious, snarky source code comments

## Getting Started

### Install

#### Composer install
    composer require hassankhan/zepto

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

***Coming soon***

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
