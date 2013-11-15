Changelog
=========

- [Changed ``Zepto\Plugin`` to be an interface](http://github.com/hassankhan/Pico/commit/3f66b55556b00e413374a1693cfae41910ef0238)
- [[ci skip] Updated README.md and TODO.md](http://github.com/hassankhan/Pico/commit/57c6d1535736d153e331857dd166936c3ba00bf0)
- [Updated README.md and style.css](http://github.com/hassankhan/Pico/commit/a79f2ce0095bd5f38e06d654ad934937d85222a5)

#### 2013.11.14 - v0.4
- [Merge branch 'feature/moar-router-updates' into develop](http://github.com/hassankhan/Pico/commit/beb3e36e1bd37aef9d4280503ed777e3e82c8387)
- [Massively refactor ``Zepto\Router`` and updated tests. Removed ``Zepto\Router::dispatch()``](http://github.com/hassankhan/Pico/commit/61e1747769f3df3f2f6e70ab437aacfb43f5c2f0)
- [Updated ``Zepto\Router`` and test](http://github.com/hassankhan/Pico/commit/2d82b48d25a091ebe6e66e66a7608dee9ef62193)
- [Merge branch 'feature/router-update' into develop](http://github.com/hassankhan/Pico/commit/cd364121a248d67f162671c614173bb4f3c427ad)
- [Fixed 404 handling, updated tests](http://github.com/hassankhan/Pico/commit/b955ef5d51649d635f5c3a55c4da1387674bc68b)
- [Removed ``default_route()`` method](http://github.com/hassankhan/Pico/commit/cedef71d67c07dc85f408a0a5b1ee87e1df0a424)
- [Merge branch 'hotfix/broken-navigation' into develop](http://github.com/hassankhan/Pico/commit/7cf156a1955cb99976a966ececf90257d285ce83)
- [Temporarily fixed navigation URLs to not break. Updated README.md](http://github.com/hassankhan/Pico/commit/f7c82d9de4616c4dd40e163f9f4fe4b8d21e1135)
- [Cleaned up ``Zepto\Router``](http://github.com/hassankhan/Pico/commit/f6434ae874e814cda55a70edfd9e12ea8e1d5261)
- [Updated test cases for ``Zepto\Router``](http://github.com/hassankhan/Pico/commit/5f1ab43f15fdeb17ac64016ecc9d8a8a23d7091e)
- [[ci skip] Fixed typo in README.md](http://github.com/hassankhan/Pico/commit/d27894457e89b096066fdac4d131bb2d824ddaa3)
- [Updated README.md](http://github.com/hassankhan/Pico/commit/14989db2a7fd181439559949b359a2153d508847)
- [Fixed project name in composer.json to be Composer-compatible](http://github.com/hassankhan/Pico/commit/61ae22b1604eb6d585786c49a9d8561f4c1772e2)
- [Cleaned up test class for ``Zepto\Router``](http://github.com/hassankhan/Pico/commit/668f6c1a8e6967717a5acfa1e55550ae63f8abfc)
- [Replaced priorities with request methods in ``Zepto\Router``](http://github.com/hassankhan/Pico/commit/88b7c5878058a1ed7d4f972c10945c7d302464be)

#### 2013.11.11 - v0.3
- [Added ``Zepto\Zepto::create_nav_links()`` to create navigation links](http://github.com/hassankhan/Pico/commit/07d23516671c88d0ba7b44f94fd5104ad7f008dd)
- [Cleaned up config.php, added ‘.’ to ``content_ext``. Fixed file extension issue in ``Zepto\FileLoader``](http://github.com/hassankhan/Pico/commit/0402d819470a5e3d6b0a976d709f76ea54e2ee19)
- [Cleaned up tests for ``Zepto\FileLoader\MarkdownLoader``](http://github.com/hassankhan/Pico/commit/154c1a1725c2568b628fae19b3d763201c2e2aa4)
- [Added blocks to and updated base.twig](http://github.com/hassankhan/Pico/commit/30a1ce17144aa8d462a5058113a570bdf3343007)
- [Updated ``Zepto\FileLoader\MarkdownLoader`` to not return empty key-values in ``meta`` and updated template check in ``Zepto\Zepto``](http://github.com/hassankhan/Pico/commit/471a8a1860708e696a886e5bbf4f4b8061afeb84)
- [[ci skip] Updated path in Sublime Text project file Updated README.md](http://github.com/hassankhan/Pico/commit/12c953547f13d8239902da4cad3e08981abf3bf7)
- [Initial commit, moved from https://github.com/hassankhan/Pico/tree/develop](http://github.com/hassankhan/Pico/commit/c3ae04c2566039956c1b08aad5ae8736ddb8a7fc)
- [Initial commit to new repo](http://github.com/hassankhan/Pico/commit/41d2f6c9b26e0bf9de02daab0fc355ab8974c958)

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
