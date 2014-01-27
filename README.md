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

### System Requirements

You need **PHP >= 5.3.0**.

### Install

![Initial setup demo](https://github.com/hassankhan/Zepto/wiki/img/zepto-setup.gif)

#### Composer install
    composer install hassankhan/zepto

If that doesn't work, try setting ``minimum-stability`` to ``dev`` in your ``composer.json`` file.

Then add the following to the top of your ``index.php`` file:

    <?php
    require 'vendor/autoload.php';

#### Manual install

***Coming soon***

### Project setup

After installing the package via Composer, pop open a terminal window, navigate to your project root and type in ``vendor/bin/zep init`` to set up Zepto for its' first run.


### First Run

Your project root should now look like this:

    .
    ├── .htaccess
    ├── composer.json
    ├── composer.lock
    ├── config.php
    ├── index.php
    └── vendor/

Crack open ``index.php`` in your text editor and you'll see

    require('vendor/autoload.php' );
    require('config.php');

    $zepto = new Zepto\Zepto($config); // Create instance of Zepto
    $zepto->run();                     // Run app

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
3. Write tests so my precious code coverage doesn't decrease (too much)
3. Send a pull request from each feature branch to the **develop** branch

It's pretty important to separate new features or improvements into separate feature branches, and to send a pull request for each branch. This allows me to review and pull in new features or improvements individually.

### Style Guide

4 space tabs, snake case method names please.
***Coming soon***

### Unit Testing

All pull requests should ideally be accompanied by passing unit tests and complete code coverage. Zepto uses [PHPUnit](https://github.com/sebastianbergmann/phpunit/) for testing.

## Community

Don't make me laugh

### Forum and Knowledgebase

**Coming soon**

### Twitter

**Coming soon**

## Author

Zepto is created and maintained by [Hassan Khan](http://hassankhan.me).

## Credits

Clearly a lot of help from [Slim](), as is apparent from the source code. This also would not have been possible without [Pico](), [Parsedown]() and many others. This project would not be available without the efforts of open-source PHP community.

## License

Zepto is released under the MIT public license.
