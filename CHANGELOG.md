Changelog
=========

#### 2013.11.10 - v0.2.2
- Cleaned up ``setup_router()`` in ``Zepto\Zepto``
- Updated text in base template
- Updated TODO.md
- Fixed routing bug in ``Zepto\Router``

#### 2013.11.10 - v0.2.1
- Removed and renamed some more hooks from ``Zepto\Plugin``
- Removed unwanted methods/hooks from ``Zepto\Plugin``
- Removed duplicated ‘$twig_options’ array in ``Zepto\Zepto``
- Added test case for ``Zepto\Router::dispatch()``
- Added Travis-CI and Coveralls.io badges to README.md
- Added test cases for ``Zepto\Router``
- Routes that end with 'index' are now hidden from the URL
- Feel confident enough to remove Pico source completely, the source is all mine (muahahaha)

#### 2013.11.09 - v0.2
- Deleted 'themes' folder
- Updated TODO.md
- Integrated Twig for templating purposes, yay!
- Moved CSS and JS into 'assets' folder
- Got rid of empty index.html files

#### 2013.11.08 - v0.1.5
- Imported basic plugin from Pico
- Updated TODO.md
- Updated ``Zepto\FileLoader\MarkdownLoader`` and related tests

#### 2013.11.07 - v0.1.4
- Updated ``Zepto\FileLoader`` and related tests in preparation for Twig integration
- Updated TODO.md
- Cleaned up ``Zepto\FileLoader\MarkdownLoader``
- Updated index.php
- Added a ``run()`` method to ``Zepto\Zepto``
- Removed index.old.php

#### 2013.11.06 - v0.1.3
- Updated tests for ``Zepto\FileLoader`` and ``Zepto\FileLoader\MarkdownLoader``
- ``Zepto\FileLoader`` and ``Zepto\FileLoader\MarkdownLoader`` now use Pimple
- Added test class for ``Zepto\FileLoader\MarkdownLoader``
- Fixed test case for ``Zepto\FileLoader``
- Updated travis.yml to include PHP 5.3
- Adding Travis-CI and Coveralls.io support
- Removed test class for ``Zepto\Zepto`` temporarily
- Generated test class for ``Zepto\Router``
- Added tests for ``Zepto\FileLoader``
- Renamed constant to ``ROOT_DIR`` in tests/Bootstrap.php
- Updated content/sub/index.md and content/sub/page.md to be shorter for testing
- Removed an errant ``var_dump()`` and ``die()``
- Added type-hint to constructor of ``Zepto\Zepto``
- Improved constant ``ROOT_DIR`` definition
- Moved Twig cache config setting
- Renamed phpunit.dist.xml to phpunit.xml.dist
- Updated TODO.md
- Cleaned up index.php
- Integrate ``Zepto\FileLoader`` with main app

#### 2013.11.05 - v0.1.2
- Fixed ``Zepto\FileLoader`` to search ``$file_path`` recursively
- Added initial template functionality
- Updated .htaccess
- Updated index.php
- Integrated Zepto with Router

#### 2013.11.03 - v0.1.1
- Updated index.php with temporary example code
- Started writing tests
- Updated ``Zepto\FileLoader\MarkdownLoader``
- Made ``Zepto\FileLoader`` more reusable
- Arrays returned by ``Zepto\FileLoader`` now only show the path relative to ``ROOT_DIR``


#### 2013.11.01 - v0.1
- Updated TODO.md
- Added bunch of other loaders, as examples
- Updated index.php and added a more configurable config.php
- Updated ``Zepto\FileLoader``, created ``Zepto\FileLoader``\MarkdownLoader``
- Created a basic file loader
- Added initial implementation of a router
- Updated README.md

#### 2013.10.31 - v0.0.1
- Unfortunately, 'klein/klein' is no longer with us :'(
- Updated composer.json with deadly amounts of dependencies, also added a lot more stuff in it for no real reason other than boredom
- Add some project settings to keep Sublime Text sane (for me at least)
- Generated test class for ``Zepto\Zepto``
- Added new index.php
- Adding in a 'library' folder, relevant initial classes
- Updated TODO.md
- Replaced michelf/php-markdown with erusev/parsedown
- Added Sublime Text project file
- Added TODO.md
- Updated composer.json to use 'dev-master' branch of Twig
- Moved 'cache' folder to project root
- Updated name to 'Zepto'
- Updated .gitignore
- Removed 'vendor' folder from project
