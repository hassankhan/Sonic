# Zepto [![Latest Stable Version](//poser.pugx.org/hassankhan/zepto/v/stable.png)](//packagist.org/packages/hassankhan/zepto) [![Total Downloads](//poser.pugx.org/hassankhan/zepto/downloads.png)](//packagist.org/packages/hassankhan/zepto) [![License](//poser.pugx.org/hassankhan/zepto/license.png)](//packagist.org/packages/hassankhan/zepto) [![SensioLabsInsight](//insight.sensiolabs.com/projects/0c830909-0499-4833-b71e-c3d659ae17fc/mini.png)](//insight.sensiolabs.com/projects/0c830909-0499-4833-b71e-c3d659ae17fc)

|Master|Develop|
|---|---|
|[![Build Status](//travis-ci.org/hassankhan/Zepto.png?branch=master)](//travis-ci.org/hassankhan/Zepto) [![Coverage Status](//coveralls.io/repos/hassankhan/Zepto/badge.png?branch=master)](//coveralls.io/r/hassankhan/Zepto?branch=master) [![Dependency Status](//www.versioneye.com/user/projects/53091b25ec137506ae000016/badge.png)](//www.versioneye.com/php/hassankhan:zepto/0.6.1)|[![Build Status](//travis-ci.org/hassankhan/Zepto.png?branch=develop)](//travis-ci.org/hassankhan/Zepto) [![Coverage Status](//coveralls.io/repos/hassankhan/Zepto/badge.png?branch=develop)](//coveralls.io/r/hassankhan/Zepto?branch=develop) [![Dependency Status](//www.versioneye.com/user/projects/53091b29ec13758aee000040/badge.png)](//www.versioneye.com/php/hassankhan:zepto/dev-develop)|

Zepto is a stupidly simple, blazing fast, flat-file CMS based on [Pico](//pico.dev7studios.com).

Zepto is a microCMS - this means there is no administration backend and database to deal with. You simply create ``.md`` files in the "content" folder and that becomes a page.

Its interface is _supposed_ to be simple and is in process of documentation. Thank you for choosing Zepto for your next project.

## Features

* Uses [Markdown Extra](//michelf.ca/projects/php-markdown/extra/) for content parsing
* Uses a powerful(ish) [Slim](//slimframework.com/)/[Silex](//silex.sensiolabs.org/)-style router
    * Standard HTTP methods
    * Route parameters with wildcards and conditions
* Dependency injection container using [Pimple](//pimple.sensiolabs.org/)
* Template rendering using [Twig](//twig.sensiolabs.org/)
* Filesystem handling using [Flysystem](//flysystem.thephpleague.com/)
* [Atom](//en.wikipedia.org/wiki/Atom_(standard)) feed and tagged posts support
* HTTP caching
* Error handling and debugging
* Application hooks and extensible components for extending functionality
* Simple configuration
* Hilarious, snarky source code comments

## Getting Started

### System Requirements

You need **PHP >= 5.3.0**, and [Composer](//getcomposer.org/) is highly recommended.

### Install

![Initial setup demo](//github.com/hassankhan/Zepto/wiki/img/zepto-setup.gif)

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

    require('vendor/autoload.php');
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

Zepto hasn't been tested on other configurations yet, but because of how similar it is to [Slim](//slimframework.com/), the same instructions should work.

## Documentation

You can check out more in-depth documentation [here](//github.com/hassankhan/Zepto/wiki/Documentation).

## How to Contribute

### Pull Requests

1. Fork the Zepto repository
2. Create a new branch for each feature or improvement
3. Write tests so my precious code coverage doesn't decrease (too much)
3. Send a pull request from each feature branch to the **develop** branch

It's pretty important to separate new features or improvements into separate feature branches, and to send a pull request for each branch. This allows me to review and pull in new features or improvements individually.

### Style Guide

* **No** extraneous whitespace. I hate it with a fucking vengeance
* Tabs should be set to **four** spaces
* Method names should be written in ``snake_case()``, rather than ``camelCase()``
* All source files should start with ``<?php`` but should **not** have an closing tag
* End files with a Unix-style newline

***Coming soon***

### Unit Testing

All pull requests should ideally be accompanied by passing unit tests and complete code coverage. Zepto uses [PHPUnit](//github.com/sebastianbergmann/phpunit/) for testing.

## Community

Don't make me laugh

### Forum and Knowledgebase

**Coming soon**

### Twitter

**Coming soon**

## Author

Zepto is created and maintained by [Hassan Khan](//hassankhan.me).

## Credits

Clearly a lot of help (especially) from [Slim](//slimframework.com/), as is apparent from the source code. This also would not have been possible without [Pico](//pico.dev7studios.com/), [Symfony](//symfony.com/), or more specifically, the [Symfony HttpFoundation](//symfony.com/doc/current/components/http_foundation/introduction.html) component, [PHP-Markdown](//michelf.ca/projects/php-markdown/) and many others. The open-source PHP community in general does a fantastic job of polishing turds.

## License

Zepto is released under the MIT public license.
