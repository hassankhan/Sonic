# Sonic [![Latest Stable Version](https://poser.pugx.org/hassankhan/sonic/v/stable.png)](https://packagist.org/packages/hassankhan/sonic) [![Total Downloads](https://poser.pugx.org/hassankhan/sonic/downloads.png)](https://packagist.org/packages/hassankhan/sonic) [![License](https://poser.pugx.org/hassankhan/sonic/license.png)](https://packagist.org/packages/hassankhan/sonic) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/0c830909-0499-4833-b71e-c3d659ae17fc/mini.png)](https://insight.sensiolabs.com/projects/0c830909-0499-4833-b71e-c3d659ae17fc)

|Master|Develop|
|---|---|
|[![Build Status](https://travis-ci.org/hassankhan/Sonic.png?branch=master)](https://travis-ci.org/hassankhan/Sonic) [![Coverage Status](https://coveralls.io/repos/hassankhan/Sonic/badge.png?branch=master)](https://coveralls.io/r/hassankhan/Sonic?branch=master) [![Dependency Status](https://www.versioneye.com/user/projects/53091b25ec137506ae000016/badge.png)](https://www.versioneye.com/php/hassankhan:sonic/0.6.1)|[![Build Status](https://travis-ci.org/hassankhan/Sonic.png?branch=develop)](https://travis-ci.org/hassankhan/Sonic) [![Coverage Status](https://coveralls.io/repos/hassankhan/Sonic/badge.png?branch=develop)](https://coveralls.io/r/hassankhan/Sonic?branch=develop) [![Dependency Status](https://www.versioneye.com/user/projects/53091b29ec13758aee000040/badge.png)](https://www.versioneye.com/php/hassankhan:sonic/dev-develop)|

Sonic is a stupidly simple, blazing fast, flat-file CMS based on [Pico](//pico.dev7studios.com).

Sonic is a microCMS - this means there is no administration backend and database to deal with. You simply create ``.md`` files in the "content" folder and that becomes a page.

Its interface is _supposed_ to be simple and is in process of documentation. Thank you for choosing Sonic for your next project.

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

Refer to [Sonic Skeleton](//github.com/hassankhan/Sonic-Skeleton) for instructions on creating a new project with Sonic.

## Documentation

You can check out more in-depth documentation [here](//github.com/hassankhan/Sonic/wiki/Documentation).

## How to Contribute

### Pull Requests

1. Fork the Sonic repository
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

### Unit Testing

All pull requests should ideally be accompanied by passing unit tests and complete code coverage. Sonic uses [PHPUnit](//github.com/sebastianbergmann/phpunit/) for testing.

## Community

Don't make me laugh

### Forum and Knowledgebase

**Coming soon**

### Twitter

**Coming soon**

## Author

Sonic is created and maintained by [Hassan Khan](//hassankhan.me).

## Credits

Clearly a lot of help (especially) from [Slim](//slimframework.com/), as is apparent from the source code. This also would not have been possible without [Pico](//pico.dev7studios.com/), [Symfony](//symfony.com/), or more specifically, the [Symfony HttpFoundation](//symfony.com/doc/current/components/http_foundation/introduction.html) component, [PHP-Markdown](//michelf.ca/projects/php-markdown/) and many others. The open-source PHP community in general does a fantastic job of polishing turds.

## License

Sonic is released under the MIT public license.
