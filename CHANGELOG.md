Changelog
=========

#### 2014.02.20
- [More updates for README.md](http://github.com/hassankhan/Zepto/commit/32a7e2139c16d35356eba379dd10efe01774942f)
- [[ci-skip] Updated README.md](http://github.com/hassankhan/Zepto/commit/4361d1f9c2a3a31e5c805848a30503200096f62b)
- [Got rid of branch aliases in Composer, and set minimum stability to stable](http://github.com/hassankhan/Zepto/commit/ceb85b107dcb10f0fbdb30a5f93da117907ef672)
- [Fixed docblock for ``Zepto\FileLoader\MarkdownLoader``](http://github.com/hassankhan/Zepto/commit/4d61dacb6bf4f9d66ca335709541d8019873314e)
- [Updated TODO.md](http://github.com/hassankhan/Zepto/commit/45057ebdf04f6181afb4448304e35d5e65c9cece)
- [Updated index.md](http://github.com/hassankhan/Zepto/commit/f87796dd26e641c0b25ab3641d1069371b36ee06)
- [Updated composer.json, trying to make dev-develop show up as unstable](http://github.com/hassankhan/Zepto/commit/61aa831bf4093accd9132079f5cd0d3fec14262c)

#### 2014.02.20 - feature/move-route-execution-from-router-to-route
- [Merge branch 'feature/move-route-execution-from-router-to-route' into develop](http://github.com/hassankhan/Zepto/commit/20d9643e4592abd67857f7f0b791db9e44b5034a)
- [General cleanup, spit and polish for ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/7407b6f2303727a3527d271677cdea64c66989f6)
- [Fixed test class for ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/d499e642b7c994c9dadc7eff6d84609de9ff835b)
- [Added a new method ``Zepto\Router::redirect()``, updated test class](http://github.com/hassankhan/Zepto/commit/c2e9c76dc83c3ace7fc88ac5e929b59e9d2ea225)

#### 2014.02.19 - feature/move-route-execution-from-router-to-route
- [Cleaned up ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/497058e60b15c51c40eca1f10a37b702e168b081)
- [Cleaned up ``Zepto\Route\ErrorRoute``](http://github.com/hassankhan/Zepto/commit/054a2ca12aeca4c4826c1aebd918632750d80dd0)

#### 2014.02.17 - feature/move-route-execution-from-router-to-route
- [Exception handling almost completely contained within ``Zepto\Router``, removed extraneous code from ``Zepto\Zepto`` and updated test classes.](http://github.com/hassankhan/Zepto/commit/0e1cee513efcec1b656f6169d55fee70d65a0786)
- [Added new object ``Zepto\Route\ErrorRoute``](http://github.com/hassankhan/Zepto/commit/7c9b982419325defa3a4ba80fe6311d118e1b988)
- [That's the basic thing done. Now need to change error handlers too.](http://github.com/hassankhan/Zepto/commit/2aab5209dd390200d667881a1972b9536aab09d4)

#### 2014.02.17 - feature/flatten-config-array
- [Merge branch 'feature/flatten-config-array' into develop](http://github.com/hassankhan/Zepto/commit/a86b25521234a1eac9a97873e3a3508ff876db5b)
- [Fix for plugins as well](http://github.com/hassankhan/Zepto/commit/a0f9699fd0c7ccd9bbc32805e7c7792bc3438ca9)
- [Flattened the settings array pretty much everywhere I can think of, also updated the tests to reflect that](http://github.com/hassankhan/Zepto/commit/c612b903c748367b76a98797299d39e512ed7d03)
- [Merge branch 'master' into develop](http://github.com/hassankhan/Zepto/commit/06b28feecf92d4e173b456dc7ae9a653dc1fae31)

#### 2014.02.17 - v0.6
- [Added setting for ``NavGenPlugin`` to config.php](http://github.com/hassankhan/Zepto/commit/1e8caa6fd184ee27d2d4ea8f10cb1f9a2034afc9)

#### 2014.02.16 - feature/refactor-console
- [Merge branch 'feature/refactor-console' into develop](http://github.com/hassankhan/Zepto/commit/290d8e792880adaee672918d203a278ad7526781)
- [Also realised ``zep``'s plugin template was out-of-date.](http://github.com/hassankhan/Zepto/commit/713871ff5fe8a96a635a6fe6cc120693c3a8936b)
- [Updated ``Zepto\Console`` and changed all method signatures to use snake case, fitting in more with my liking](http://github.com/hassankhan/Zepto/commit/fedf7309dbf83f8d5755b4a1f7e44f51d26e8b40)
- [More test fixes for ``Zepto\Console``](http://github.com/hassankhan/Zepto/commit/1edc0281956190658f9fcb6a3c8ab88c93f68f2d)
- [Some cleanup of ``Zepto\Console`` and related test class](http://github.com/hassankhan/Zepto/commit/9f3329624af17d6a8d967bfb3901cb3817213a88)
- [Lost a lot of code coverage, but that's good because it'll force me to write better tests](http://github.com/hassankhan/Zepto/commit/eb0250bc9557a6c8e6da97dd016811e77b1af81e)

#### 2014.02.16
- [Updated ``Zepto\Zepto`` version to 0.7.](http://github.com/hassankhan/Zepto/commit/272ab0969294df0604d9fbb8e72e219c441a63b1)
- [Updated CHANGELOG.md, composer.json. Brace yourselves, Zepto 0.6 is coming.](http://github.com/hassankhan/Zepto/commit/af10bb48accad9d69c68a3b0ffc12cc5f92e894d)
- [Forgot to update ``zep``](http://github.com/hassankhan/Zepto/commit/a0eb60f485bb219028c8087f4e11b5600297b963)
- [Cleaned up ``Zepto\Zepto::run_hooks()``](http://github.com/hassankhan/Zepto/commit/d2ccec85caea8be083616605f51e7ed6da51314a)
- [Nothing major, just docblock tag updates](http://github.com/hassankhan/Zepto/commit/9eca741e528f50388913620310e0667a85572f52)
- [Added docs and tests for ``Zepto\FileLoader::get_folder_contents()``](http://github.com/hassankhan/Zepto/commit/5be421c8e0c71cf405cd9f01633511f6111034b0)
- [``Zepto\Helper::url_for()`` and ``Zepto\Helper::link_for()`` now both return null if a file is not found. Also updated test class.](http://github.com/hassankhan/Zepto/commit/4adf126f11bfa28a91aec21e6b1a596fb1aad23e)
- [Updated CHANGELOG.md and TODO.md](http://github.com/hassankhan/Zepto/commit/cfbb5b08573f4be73152a38c95cfc7c2677daf8a)

#### 2014.02.15
- [Added a Fork Me banner](http://github.com/hassankhan/Zepto/commit/2c2984a185a90f96ea5c6ff310639c8b824fe0f4)
- [Updated index.md](http://github.com/hassankhan/Zepto/commit/3424aa1e835c179f29495a12bd893bb0b2bb05b4)

#### 2014.02.13
- [Changed method signatures for all hooks to include app container](http://github.com/hassankhan/Zepto/commit/0d62620d501f9da2b423997442a7fc3c8c8acc73)
- [``WhoopsPlugin`` will now no longer load if Zepto is in dev mode](http://github.com/hassankhan/Zepto/commit/f45e8cf11110fccf3573136b20aace98c5f4c731)
- [Removed some silliness from ``Zepto\Helper::validate_config()``](http://github.com/hassankhan/Zepto/commit/fa88dcb8b5a242c81f570334158bc01a54c321b4)
- [Added test class for ``Zepto\Extension\Twig`` and updated test class for ``Zepto\Zepto``](http://github.com/hassankhan/Zepto/commit/4238744166cc013b28b609fe03beb22a1cb9f63b)
- [Updated .travis.yml](http://github.com/hassankhan/Zepto/commit/de5c631dcd78e456b44bd80ede175678887560f6)
- [Merge branch 'feature/move-nav-gen-to-plugin' into develop](http://github.com/hassankhan/Zepto/commit/1f726045c336fe9c171dc29d337c50c68fb6f573)
- [Small change to ``Zepto\Helper::link_for()``](http://github.com/hassankhan/Zepto/commit/0ed77b42f44c8c1099cf88bfa7b6ef93823b1ad5)
- [Initial, somewhat working version of ``NavGenPlugin``](http://github.com/hassankhan/Zepto/commit/48cbed7e987e9f94cd3ce933adc76c37882c70d8)
- [Updated all Plugin docblock headers](http://github.com/hassankhan/Zepto/commit/b0843dd9a154f339f73ffcaa101cda662c4f6701)
- [Added spacing to link markup in ``Zepto\Helper::link_for()`` and updated test class](http://github.com/hassankhan/Zepto/commit/47fa98d0e6ef3c1ef8c675c6b7454a26e6cc769b)
- [Fucks sakes, mate](http://github.com/hassankhan/Zepto/commit/13bb1089d0ec2e66748e6706dbce1f87ce0c92d3)
- [Moved ``Zepto\Zepto::run_hook()`` calls to the constructor for readability.](http://github.com/hassankhan/Zepto/commit/4e855a4b95948b61dc76513be147e7e2c0b1b5bd)
- [``Zepto\Helper::url_for()`` now makes URLs end with a '/'. Also removed some dead code and updated test class.](http://github.com/hassankhan/Zepto/commit/5c1f5be4aa813ac6ceca1c12fc7032d7b417d176)

#### 2014.02.12
- [I think this should close #8](http://github.com/hassankhan/Zepto/commit/1fe621b4c8ab83a2fb057eb42a7b290fab03de9a)
- [Some more progress on issue #8](http://github.com/hassankhan/Zepto/commit/54590ec2c64340af149d0702dfc4d94a1914d628)
- [Removed constant ``ROOT_DIR`` from ``Zepto\Zepto``, and got rid of try-catch around the plugin loader.](http://github.com/hassankhan/Zepto/commit/9e5b720f01cb112a6ad88246e777f913cc1fc99a)

#### 2014.02.12 - feature/move-nav-gen-to-plugin
- [Changed ``Zepto\ZeptoTwigExtension`` to ``Zepto\Extension\Twig``, updated ``Zepto\Zepto`` accordingly](http://github.com/hassankhan/Zepto/commit/3b605e0c790531f906fc2be301a74c975d810b30)
- [Merge branch 'develop' into feature/move-nav-gen-to-plugin](http://github.com/hassankhan/Zepto/commit/c8bb48300c0e26c91245f9ef371d361c8129e23f)
- [Updated test class for ``Zepto\Zepto``](http://github.com/hassankhan/Zepto/commit/42945a8511d036ef2bf5a5814f48e1aa1c23b455)
- [Another change that should've been in 490b695](http://github.com/hassankhan/Zepto/commit/e792ce74bf86cd0d6ce1af6ee65597f1c540400f)
- [Updated test class for ``Zepto\Zepto`` and added new test class for ``Zepto\Helper``](http://github.com/hassankhan/Zepto/commit/fa880eca7044813de875a650007abed938ceb2f9)
- [``$app['nav']`` in ``Zepto\Zepto`` is empty unless specifically set. This should probably be changed.](http://github.com/hassankhan/Zepto/commit/f3b469a8b289561225f4fceba593dfb961412c16)
- [Removed ``create_nav_links()`` method call from ``Zepto\Zepto::_construct()``](http://github.com/hassankhan/Zepto/commit/703727966228898e11f7bb0799d0584273eb769c)
- [Major cleanup for ``Zepto\Zepto``. Removed method ``create_nav_links()``, moved ``default_config()`` and ``validate_config()`` to ``Zepto\Helper`` and moved ``generate_nav_html()`` to ``NavGenPlugin``](http://github.com/hassankhan/Zepto/commit/0e4d2d471a58a9e282b30b6457d0a064e16dbaa2)
- [Changed other references to ``$c`` or ``$container`` to ``$app``, following on from 490b695](http://github.com/hassankhan/Zepto/commit/328d139d6a65fff736763fd8f9aed01811fc86a7)
- [Added new class ``Zepto\Helper`` to hold all helper methods, added ``link_for()`` and ``url_for()``  to it. Removed same methods from ``Zepto\Zepto``](http://github.com/hassankhan/Zepto/commit/88aa519078c7cccf031aca380a80f8d0f33aa442)
- [Added new method ``Zepto\Zepto::link_for()`` to generate HTML output for a link](http://github.com/hassankhan/Zepto/commit/d74095313fb5fbd8112f36b4fd54d0cd88f3cc3f)
- [Renamed ``$container`` to ``$app`` inside ``Zepto\Zepto``](http://github.com/hassankhan/Zepto/commit/490b695f3b690b4632b332d820957e5c25e5e6e4)

#### 2014.02.11 - feature/move-nav-gen-to-plugin
- [Created new ``NavGenPlugin``](http://github.com/hassankhan/Zepto/commit/ef77b7d2353d24e17b3e58772f16c71ca042efa8)
- [Added new ``Zepto\ZeptoTwigExtension`` to handle all the fun Twig functions and stuff.](http://github.com/hassankhan/Zepto/commit/eb9b44557205da5324b925d47df6746c172e3f3a)
- [Merge branch 'develop' into feature/move-nav-gen-to-plugin](http://github.com/hassankhan/Zepto/commit/1fd54d2924eee7204f46064a37a7ead1b4a080fd)
- [Added new method ``Zepto\Zepto::url_for()``. Give it a filename, and it checks to see if it's a valid file in the 'content' directory and returns its' fully-formed URL](http://github.com/hassankhan/Zepto/commit/3fe47e58b261012ff5805280f77feb39a1027069)

#### 2014.02.10
- [Added new method ``Zepto\Zepto::instance()`` to check whether a static instance has been set and if so, return it.](http://github.com/hassankhan/Zepto/commit/5b8697132cf236a11d5eaaa004d015a2500baf7f)

#### 2014.02.10 - feature/rewrite-fileloader-stuff
- [Seems like you were never meant to be, ``testLoadContent()``](http://github.com/hassankhan/Zepto/commit/52e3b5b4500c486051bcbf788c69e4180ac9a405)
- [Got rid of ``Zepto\PluginInterface::before_content_load()`` and ``Zepto\PluginInterface::after_content_load()``, jiggled around with ``Zepto\Zepto`` constructor, so the plugin loading happens before config "load", but it does get validated. Some win?](http://github.com/hassankhan/Zepto/commit/197574028a9d04f36b3d0466b99189149048c3c0)
- [*sigh* fuck you, PHP 5.3](http://github.com/hassankhan/Zepto/commit/5052c2ebe6181c6cabcc0deeef1d513d02bc1e67)
- [Fix for ``Zepto\Zepto`` due to another curveball PHP 5.3 sends over.](http://github.com/hassankhan/Zepto/commit/caf5ba575c4ada26d76de5bb78dda6a52973ecf3)
- [Updated README.md and docblock for ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/6631d004095c6be45489a117af4d5e830d80ae22)
- [Merge branch 'feature/rewrite-fileloader-stuff' into develop](http://github.com/hassankhan/Zepto/commit/6a5033474697ed2c010039a7f2af900564e0bb3d)
- [Small changes to ``Zepto\Zepto``, updated test class to reflect broken method ``Zepto\Zepto::create_nav_links()``](http://github.com/hassankhan/Zepto/commit/50860b5fc7ba71d84aa72edf6b223dff1fa63e59)
- [So.... this is where we get to lazy-load the files, right in the callbacks. At the minute, it breaks the ``<nav>`` generation but that's a minor detail.](http://github.com/hassankhan/Zepto/commit/2b3870dc454b78613b14509a7697a6da9f4c58be)
- [Small updates for ``Zepto\FileLoader\PluginLoader`` and test class.](http://github.com/hassankhan/Zepto/commit/9feb62968f699acb0cb7393078099291a195551e)
- [Added ``Zepto\FileLoader::get_folder_contents()`` in favour of ``Zepto\FileLoader::get_directory_map()``. Updated test class some.](http://github.com/hassankhan/Zepto/commit/533449cb56af58f1ed3e9910d27b01a84bf5e98d)
- [Rewritten ``Zepto\FileLoader\MarkdownLoader``, updated test classes. Marked as deprecated, hopefully can use pages in the future.](http://github.com/hassankhan/Zepto/commit/f50a8ee835f76cf502dff6aebad568bd7ccbf363)

#### 2014.02.08 - feature/rewrite-fileloader-stuff
- [Added test mock-type thingies for testing ``Zepto\FileLoader\PluginLoader``](http://github.com/hassankhan/Zepto/commit/2892e3dcadbb323998b581c7789dbe7e3ddcf847)
- [Just renamed a test for ``Zepto\FileLoader``](http://github.com/hassankhan/Zepto/commit/6b6d6af270f3134e50ca7816e112b988bb142c61)
- [Updated and refactored ``Zepto\FileLoader\PluginLoader``. Now throws a crapton of exceptions at you if you fuck anything up. Also fixed a bug to do with checking for a valid plugin name. Lots of other sit too, I can't really remember.](http://github.com/hassankhan/Zepto/commit/1e85c924d76fb7d41ac1f3f45e43bbfca8600125)
- [``Zepto\FileLoader`` now throws an exception on initialization if the base path is not a valid directory. Also updated test class.](http://github.com/hassankhan/Zepto/commit/677b114fd589ec33342f6ca0ab00272ac623dd07)

#### 2014.02.06 - feature/rewrite-fileloader-stuff
- [Cleanup and refocussed ``Zepto\FileLoader``](http://github.com/hassankhan/Zepto/commit/585275120ac849d456a572178c5fca0c79fb513a)

#### 2014.02.04
- [I hope this works](http://github.com/hassankhan/Zepto/commit/e4f9065b033825f5e8618691bb5d39e8638c835a)
- [Another small update, nothing massive](http://github.com/hassankhan/Zepto/commit/d0ed1088f13624942219d96ae8d21aa62d74b408)
- [Small updates, nothing massive](http://github.com/hassankhan/Zepto/commit/497c2c3ca66799dd475d1dfea316b126741080d5)
- [Fixed and updated test class for ``Zepto\Zepto``](http://github.com/hassankhan/Zepto/commit/5070eea8c8c8aeb7575f0edcb3d13cd2d18f7984)
- [Added new ``Zepto\Zepto::validate_config()`` method to validate some parameters from ``$config``](http://github.com/hassankhan/Zepto/commit/6788b544b8110303a41b5ed63d2cb9b8e3da27f7)
- [Adding basic support for environments, first step for issue #4](http://github.com/hassankhan/Zepto/commit/1425c3bc5589278da0597148633a7c881ba19b16)
- [Fixes failing Travis tests, put a hard version number for Pimple](http://github.com/hassankhan/Zepto/commit/3ce5769fffe2f163d0de23d9b5b9b93c12a77c4b)
- [Changed ``Zepto\Zepto::default_config()`` visibility to ``public``](http://github.com/hassankhan/Zepto/commit/a9c08bd1be7f8b56964839ad66f6b454a1b05e3d)

#### 2014.02.03
- [Renamed ``Zepto\Zepto::router_setup()`` to ``Zepto\Zepto::setup_router()``](http://github.com/hassankhan/Zepto/commit/796a8bd561edf47dd2b5312e225b71259036923b)
- [Renamed ``Zepto\Zepto->container['file_loader']`` to ``content_loader``](http://github.com/hassankhan/Zepto/commit/a676222114d468d93d44eb4394535b9b6919bccd)
- [Small update to ``WhoopsPlugin``](http://github.com/hassankhan/Zepto/commit/0033a8f814f28b425808749260d0832333f803ab)
- [Fixed Response header's content-type](http://github.com/hassankhan/Zepto/commit/6aae32e6f16b824d544899f4bc4253e21281db70)
- [Updated docblocks for ``Zepto\Zepto`` and ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/e7ba8ad6c4f213a5b33c8477163436bc9a8c8bdc)

#### 2014.02.02 - feature/plugin-overhaul
- [Updated README.md and TODO.md](http://github.com/hassankhan/Zepto/commit/6668447b207eee0b0a01562b73cc45c6b95c75a0)
- [Updated ``zep``](http://github.com/hassankhan/Zepto/commit/1a59d4fffa8d0409ffcf95ccec1cbd57779204c8)
- [Slight changes to ``Zepto\Router`` and ``Zepto\Route``](http://github.com/hassankhan/Zepto/commit/e724c7668d4eeeabf901ec323acdda14f631fe9f)
- [Added a new method ``Zepto\Zepto::default_config()``](http://github.com/hassankhan/Zepto/commit/72b8741b0b6912a7a64e23512b089f826940f19e)
- [Renamed ``Zepto\Zepto::setup_router()``to ``Zepto\Zepto::router_setup()``](http://github.com/hassankhan/Zepto/commit/fa13f262410e962c58befbf8f364a54308926ada)
- [Fixed failing test classes](http://github.com/hassankhan/Zepto/commit/918df55683cfd8cc5b07df0781f757b4a10b4ac0)
- [Merge branch 'feature/plugin-overhaul' into develop](http://github.com/hassankhan/Zepto/commit/3e0780cefb5b0a695d9b8e9c338d97afb39b670c)
- [Renamed hook ``*_file_load`` to ``*_content_load``](http://github.com/hassankhan/Zepto/commit/e31dd4aae655362374511b882c3447570c9e91e5)
- [Fixed all plugins to properly implement ``Zepto\PluginInterface``](http://github.com/hassankhan/Zepto/commit/66c04a5e6543970e40570e98713376d201b93cd2)
- [Added new plugin hooks ``before_router_setup``, ``after_router_setup``, ``before_response_send``, ``after_response_send``. Also routed application errors to ``Zepto\Router::error()``](http://github.com/hassankhan/Zepto/commit/031c870e516e4fb581f19588bce5e4ccd1a505ac)
- [Changed ``Zepto\Router::error()`` to accept either Closures or Exceptions](http://github.com/hassankhan/Zepto/commit/4ce9fabb1391432f07419550eea47ee4e2cdff84)
- [Refactored ``Zepto\FileLoader\PluginLoader``, now validates plugins to see if they implement ``Zepto\PluginInterface``](http://github.com/hassankhan/Zepto/commit/509ce9e9ab3ca5c3de14bb03258272f7e9f3e5ab)
- [Removed all hardcoded Whoops references from ``Zepto\Zepto``](http://github.com/hassankhan/Zepto/commit/a9ca955b41359e20b4dcef4498b194cf39d64b84)
- [Cleaning up ``WhoopsPlugin``](http://github.com/hassankhan/Zepto/commit/35aae18e2ca523a070d7d2cee1f7442c227644bb)
- [Initial implementation of ``WhoopsPlugin``](http://github.com/hassankhan/Zepto/commit/6aca3038224c63b6f2415330c878edabaaf9af35)

#### 2014.02.01
- [Merge branch 'develop' into feature/plugin-overhaul](http://github.com/hassankhan/Zepto/commit/a91db24573fff1d2a47379138f224970af7542a1)
- [Hopefully final fix for these random failures](http://github.com/hassankhan/Zepto/commit/b5bbd37f7912c5532fe80d363c36b291b2762352)

#### 2014.01.31 - feature/use-symfony-httpfoundation
- [Updated docblock for ``Zepto\Zepto::__construct()``](http://github.com/hassankhan/Zepto/commit/38f94347d7f58c27f7f3ca630c79d89fbf4b706b)
- [Updated test class for ``Zepto\Zepto``, now doesn’t display useless output](http://github.com/hassankhan/Zepto/commit/6e5f32de1cd15e6917a8f66b23fc575c99eed96b)
- [Merge branch 'feature/use-symfony-httpfoundation' into develop](http://github.com/hassankhan/Zepto/commit/c01f5428a02885a9a6b830505a4a5f2adf2fc610)
- [Updated ``Zepto\Router`` and its’ test class to use more specific exceptions](http://github.com/hassankhan/Zepto/commit/f77094826a4edb9d47e7bb4c72b72a158f4568e6)
- [Added test class for ``Zepto\Route``](http://github.com/hassankhan/Zepto/commit/ff5dbdf5959037934971826b06735453506e75d2)
- [Updated test class for ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/21014fbb09812e87b5f19bf56089522080c3f766)
- [Docblock updates in ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/3109cc6f249b097ea46a11f5c62a3027f06514e8)
- [``Zepto\Router::route()`` now checks to see if method specified is a valid HTTP method before adding to the routing table](http://github.com/hassankhan/Zepto/commit/ce6b56ede9b6c09de3a4dc35ebfe5f27bcfba894)
- [Small fixes for error handlers in ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/26e15d27c5031ab51571fb36b3e3477f74f9520a)
- [Updated test class for ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/904ac54e6335d93e942c001d4259a6432517695e)
- [Fixed a problem with ``Zepto\Router::run()`` where callback functions were being passed an array instead of parameters](http://github.com/hassankhan/Zepto/commit/106e9516014a732bb4e0e2cbe4885218e7834672)
- [``Zepto\Router`` now keeps track of the current route’s HTTP status](http://github.com/hassankhan/Zepto/commit/faf05d6894a670a209c70df4999f10a6d54c9a57)
- [Moved ``Zepto\Route::route()`` method](http://github.com/hassankhan/Zepto/commit/0d082567c1445137c9fda67cf8b4fd9398a1de0d)

#### 2014.01.30 - feature/use-symfony-httpfoundation
- [Removed ``Zepto\Router::execute()``, moved logic to ``Zepto\Router::run()``, now 500 errors are officially handled. Fixed reference in ``Zepto\Zepto`` as well.](http://github.com/hassankhan/Zepto/commit/67311df6d885338c78d885acc8947202fb8548dd)
- [Added ``Zepto\Router::generate_error_template()`` to create generic HTML templates for error pages](http://github.com/hassankhan/Zepto/commit/fb45afbe2b753852cfc1856690f54b584a38c2f3)
- [Switched ``Zepto\Router::match``’s parameter order](http://github.com/hassankhan/Zepto/commit/5223de1806d1b5dc09f4658a78baf1914b16d104)
- [Renamed and updated accessor methods in ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/08441c9ee60a60587a656cadddfae1813011b78c)
- [Renamed accessor methods in ``Zepto\Route``](http://github.com/hassankhan/Zepto/commit/9491a4cd8a1b1c41d1dc3c40eaad8b72d0368861)

#### 2014.01.29 - feature/use-symfony-httpfoundation
- [Docblock cleanup for ``Zepto\Route``](http://github.com/hassankhan/Zepto/commit/9a0f719c090803cdbe6f921b9d204cebb98b7aa8)
- [``Zepto\Zepto`` now sends an instance of ``Symfony\Component\HttpFoundation\Response`` to ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/b5a5e3ca037c21bf7a2dbefbdcf6b671a58ea37d)
- [``Zepto\Router`` now uses Response objects to return data to the client, added HTTP methods as class constants, general code restructuring](http://github.com/hassankhan/Zepto/commit/266730ec95ed4a9984893dcb7763b654dc50ea3c)
- [General fixes to accommodate new and improved ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/b61f7065b27f52cc49fb8d215dbc9b3556f19350)
- [Now with the power of ``Symfony\HttpFoundation``](http://github.com/hassankhan/Zepto/commit/2dd612af41c4880693dabdb4298df9ecc284535f)
- [Removed parameters from ``Zepto\Route``](http://github.com/hassankhan/Zepto/commit/59d9f33e4578efc59f42910c8b36ac5ba764cc84)
- [Added a new method to ``Zepto\Router`` to parse parameters from the URL](http://github.com/hassankhan/Zepto/commit/aebd11f3e709775c8af1869f7c7cad63c75b77d9)
- [Fix for ``Zepto\Router::match()``](http://github.com/hassankhan/Zepto/commit/3e733e810cbeac402ae5a16725bd90fb6b9a2f5c)
- [Fixed ``Zepto\Router::post()``](http://github.com/hassankhan/Zepto/commit/462bea2c1838c91dfe2d563dd4bc6ffabc245cf8)
- [Changed ``Zepto\Router`` to use regex patterns in routing table rather than URLs](http://github.com/hassankhan/Zepto/commit/39c092ab8d8927d34ea0b23391b9774808cca935)
- [Major refactor of ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/23218ec4bad4b8e2a433f654e931c92c57cc516f)
- [Added typehint to constructor in ``Zepto\Route``](http://github.com/hassankhan/Zepto/commit/bfaeeec0a0e38751e9e81684718daf21b11cd5cc)

#### 2014.01.28 - feature/use-symfony-httpfoundation
- [Merge branch 'develop' into feature/use-symfony-httpfoundation](http://github.com/hassankhan/Zepto/commit/1a5aad54f6a5b98decaf6585b5e4a21af28dd49d)
- [Added new ``Zepto\Route`` object](http://github.com/hassankhan/Zepto/commit/ec80489ca0821ed6043f9fee36ad6e966b85053b)
- [Cleaned up some stuff in the constructor of ``Zepto\Zepto``](http://github.com/hassankhan/Zepto/commit/146d3cdca402e7c90b2790f8c3410ae37c0c3015)
- [Started working on abstracting Whoops into a plugin](http://github.com/hassankhan/Zepto/commit/15863fa31683d94350ee1f7c3b9a769fbd454251)
- [Added ``Symfony\HttpFoundation`` to composer.json](http://github.com/hassankhan/Zepto/commit/457fa63a6fae9bc5d9547e40dea49bd86829311e)

#### 2014.01.27
- [[ci-skip] Added GIF to README.md](http://github.com/hassankhan/Zepto/commit/2096f184fea51802d7d41c15cb6f8d62a19f6b08)
- [[ci-skip] Updated README.md and TODO.md](http://github.com/hassankhan/Zepto/commit/d1b3598627704de8ad80073f8faa2ce42ceea292)
- [Fleshed out ``zep init`` some more](http://github.com/hassankhan/Zepto/commit/f9dd801b52cefed31454e2e3c4b843a637cce58c)
- [Don’t understand why this particular test fails](http://github.com/hassankhan/Zepto/commit/4a0d398c21c9ac1b312af572fb0ce5f9892c8648)
- [??? Profit?](http://github.com/hassankhan/Zepto/commit/21045ba506627d809ade8194ba5c7c40170cdc7c)
- [Merge branch 'feature/fix-after-config-load' into develop](http://github.com/hassankhan/Zepto/commit/721264289c9056d5b8d73a04bdd6480149bbe219)
- [Updated ``Zepto\Zepto`` to reflect new hook sequence. Fixes #5](http://github.com/hassankhan/Zepto/commit/32d0322a08316a87294fba006eee895a307957b8)
- [``Zepto\PluginInterface::after_config_load()`` is now ``before_config_load()``, allows for a chance to hook into app settings before they are fully loaded. Updated ExamplePlugin and OtherExamplePlugin to show changes](http://github.com/hassankhan/Zepto/commit/50944db0d2e849c03c4969ed2364cc9f4663d2ac)
- [Adding HHVM support to Travis-CI. Fixes #3](http://github.com/hassankhan/Zepto/commit/e19203f26c1cc4344a2265b44bc6874cbe53191a)
- [Merge branch 'feature/fix-the-fucked-up-paths' into develop](http://github.com/hassankhan/Zepto/commit/9deb943263323e4e51d442e0fb54a3581ff40730)
- [This should fix any project root path conflicts when using Zepto as installed from Composer](http://github.com/hassankhan/Zepto/commit/5e172b0d92518edb8f938307a3928ea4ea7b5d1c)
- [Fix for character-escaping bug in plugin template in ``zep``.](http://github.com/hassankhan/Zepto/commit/6a6ec97abd7bd75612255d4e1b14e6e741510ac0)

#### 2014.01.26 - feature/initial-setup-tools
- [``Zepto\Console`` now uses double-quotes everywhere. Also updated test class accordingly.](http://github.com/hassankhan/Zepto/commit/cc1eb8b0d002ec2753668d96c2a42db5840eb583)
- [[ci-skip] Fixed a bug with ``zep`` where using from ``vendor/bin`` was not working.](http://github.com/hassankhan/Zepto/commit/096ae08e4ad61592619b4bf66660a6213d2a501c)
- [Not sure if code is shit, or found bug in Travis-CI](http://github.com/hassankhan/Zepto/commit/c5406d57035d59681260fd61ec044fac8208394a)
- [Merge branch 'feature/initial-setup-tools' into develop](http://github.com/hassankhan/Zepto/commit/1a8172eaa824f019d3bba2233b88f767281b4d5d)
- [Updated README.md and TODO.md](http://github.com/hassankhan/Zepto/commit/c47ac356ab7104a071fdabb1548b525c7e12fa9d)
- [Obligatory snarky message added.](http://github.com/hassankhan/Zepto/commit/c0f9ce0428d1b51de8a710150bcaf8732af91df8)
- [Added some comments, etc. to ``zep`` tool](http://github.com/hassankhan/Zepto/commit/f5da86332827e8fe5f712c33e5c90ad1987318dd)
- [Automatically add a space to the end of a confirm message](http://github.com/hassankhan/Zepto/commit/31b8fc6d3856387870219574c0f87d8f4ee67617)
- [Added basic stuff for ``zep init`` command.](http://github.com/hassankhan/Zepto/commit/1c1f6142b73af65deb6b19a706c41b7d6d0bd7b9)
- [Merge branch 'develop' into feature/initial-setup-tools](http://github.com/hassankhan/Zepto/commit/602d532fb858f6433e6bc5daf4ad7304e294bbc5)

#### 2014.01.24 - feature/use-michelf-php-markdown
- [Updated version number and fixed migration to ``michelf/php-markdown``](http://github.com/hassankhan/Zepto/commit/2280800fc79a7d19cb1eb0f4f1e191245d4a9c01)
- [Merge branch 'feature/use-michelf-php-markdown' into develop](http://github.com/hassankhan/Zepto/commit/782f3b44f149b47431eb77275c60af5f69ee2783)
- [Updated ``Zepto\FileLoader\MarkdownLoader`` to use dependency injection and related test class](http://github.com/hassankhan/Zepto/commit/b47e8eccd8057c16550ca13fb2ef3f9c18f1c280)

#### 2014.01.23 - feature/use-michelf-php-markdown
- [Updated ``Zepto\FileLoader\MarkdownLoader`` to use ``michelf/php-markdown``](http://github.com/hassankhan/Zepto/commit/e599e1bc18ebdb7fb0e52d3b1729b2eac1100a6f)
- [Updated composer.json to use ``michelf/php-markdown``](http://github.com/hassankhan/Zepto/commit/2fd724c2dbf11cdd3afb676f3fa1b581e6d4598b)

#### 2014.01.22 - feature/initial-setup-tools
- [Updated ``Zepto\Console`` and its test class](http://github.com/hassankhan/Zepto/commit/ddfe1160e532b97976b9fe74ad16ac39565bdc5e)
- [Changing all single quotes to double quotes. ``zep`` now generates content files as well.](http://github.com/hassankhan/Zepto/commit/ece328c731d587ddd39e269bd522990da3ddb1ad)
- [``zep`` CLI utility now creates plugins](http://github.com/hassankhan/Zepto/commit/fe79023f3719067a77037f085336d34696ebb855)
- [Automatically add a space to the end of a prompt message](http://github.com/hassankhan/Zepto/commit/406040959d3d43e61a27d654454f959c4e836c70)
- [Updated composer.json to symlink ``zep`` utility to ``vendor/bin``](http://github.com/hassankhan/Zepto/commit/9dbc5ce7a6df1cb3fbe8571d094fd801eb989161)
- [Made ``zep`` binary again, added more structure to it.](http://github.com/hassankhan/Zepto/commit/b8ee48eeee883f86aa36c0b31c2563ddacb74721)
- [Added a new zep.php file for CLI. Removed ``zep`` tool](http://github.com/hassankhan/Zepto/commit/00bcf96fed21b78b59281938135aa47527b4140c)
- [Added new class ``Zepto\Console`` and related test class.](http://github.com/hassankhan/Zepto/commit/53e3a39080e253d283768d36bb6874c89cb600a6)

#### 2014.01.21 - feature/initial-setup-tools
- [Merge branch 'develop' into feature/initial-setup-tools](http://github.com/hassankhan/Zepto/commit/61736157359c82544e4776bd8a4174b44291c5c5)
- [[ci-skip] Updated composer.json](http://github.com/hassankhan/Zepto/commit/b0dd3a806f6c54053ef873d0d944fc8bee33a301)
- [Type-hinting for method signatures and cleanup in ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/886a99202029406e7eba6239205619374d73ae87)
- [[ci-skip] Updated TODO.md](http://github.com/hassankhan/Zepto/commit/a845684701a9ce3ff9e93bada19238df0e178b3b)
- [[ci-skip] Updated README.md and TODO.md](http://github.com/hassankhan/Zepto/commit/988e9a3696a3af58b3c2e2759ae5d4495a3ca66d)
- [[ci-skip] Updated README.md](http://github.com/hassankhan/Zepto/commit/780d823468a22753813f9b3b8ba1fea371edf5aa)
- [Adding more structure to ``sep``](http://github.com/hassankhan/Zepto/commit/f6c97e2ce4f03d8865c16684e48a5b0740963692)
- [Added new ``zep`` CLI tool to help with initial setup](http://github.com/hassankhan/Zepto/commit/059327fc96da74530886df997b926cf4331367a9)
- [Updated test class for ``Zepto\FileLoader``](http://github.com/hassankhan/Zepto/commit/7da272bab023654b8155a6b18d592afdae2007cb)

#### 2014.01.20
- [Made ``Zepto\FileWriter`` more error-resilient, and updated related test class](http://github.com/hassankhan/Zepto/commit/ff6fbf74478946df788e40bb47762ef1b309306a)
- [Minor fixes for navigation HTML generation](http://github.com/hassankhan/Zepto/commit/dd189a360e3c5ca72855e93901cca82e158a0b35)
- [Renamed ``Zepto\Zepto::get_sitemap()`` to ``Zepto\Zepto::generate_nav_html()``. This method now generates pre-formatted HTML, rather than a multidimensional array](http://github.com/hassankhan/Zepto/commit/c38054aaf988cdbe0d3437caa6c86defa7b7475b)

#### 2014.01.13 - feature/big-ass-nav-improvement
- [Merge branch 'feature/big-ass-nav-improvement' into develop](http://github.com/hassankhan/Zepto/commit/ab0ef4c3850738f56de649fc171da4c8c726eb11)
- [Merge branch 'feature/update-docs-n-tests' into feature/big-ass-nav-improvement](http://github.com/hassankhan/Zepto/commit/495365763d43ee0ad411195e36caebdcb3566487)
- [Merge branch 'develop' into feature/big-ass-nav-improvement](http://github.com/hassankhan/Zepto/commit/24fed156d63c0e730b497dde98aa73b71036609a)
- [Added new options to config file](http://github.com/hassankhan/Zepto/commit/afbf64a96ffb027dd3ac5988dd7e8fb7df9db6e0)
- [Added more test cases for ``Zepto\Zepto``](http://github.com/hassankhan/Zepto/commit/af564f80f36c32ac6319c8c9d7496ca215443095)
- [Fixed coverage tag for test class of ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/4820aeffff36482aa6d6af85a5fd15cf7ca43486)
- [Fixed constant definition for ``ROOT_DIR`` in test bootstrap file](http://github.com/hassankhan/Zepto/commit/eb4d47e75e18a897cfdc068785be5c9161ed2514)
- [Deleted empty constructors in ``Zepto\FileLoader\PluginLoader`` and ``Zepto\FileWriter``](http://github.com/hassankhan/Zepto/commit/3695ddffa7c1ce7181b107fd466220f86016344c)
- [Fix to get all header tags from content file](http://github.com/hassankhan/Zepto/commit/6154390fbc1e02c997b12bc761d53b8c89593438)

#### 2014.01.10
- [Removed ``base_dir`` option from Twig templates](http://github.com/hassankhan/Zepto/commit/443012f6fc6ef23248cf8d68d9dcab27c09bf215)
- [Renamed ``Zepto\Zepto::map_directory_to_array()`` to ``get_sitemap()``](http://github.com/hassankhan/Zepto/commit/bb71b013f5e77be69678c771886a94568c759a2a)

#### 2014.01.07
- [Added ``map_directory_to_array()`` to ``Zepto\Zepto`` to help with navigation link-making](http://github.com/hassankhan/Zepto/commit/945258d9d141a122b873032f608f6c10c320fb20)

#### 2014.01.06
- [Added a new method ``get_directory_map()`` to ``Zepto\FileLoader``](http://github.com/hassankhan/Zepto/commit/34960bbcebc2ea017f87bfa44c263aafccafbcbf)

#### 2013.12.18
- [Added a fix to set response header correctly for a 404 error](http://github.com/hassankhan/Zepto/commit/d999a3502007474e20a3d6e20bb25c0534d85905)
- [Renamed ``routes_original`` to ``original_routes`` for consistency](http://github.com/hassankhan/Zepto/commit/82e71312718ad6de9e3760713e43c7246055c5c0)
- [Added coverage for methods called in constructor](http://github.com/hassankhan/Zepto/commit/2ffa5021a18091c56847f7c30ad5de3a8683d701)

#### 2013.12.15 - feature/file-writer
- [Merge branch 'feature/update-docs-n-tests' into develop](http://github.com/hassankhan/Zepto/commit/111f2bfc5cc5c680d61cc245414e23387c8c4f82)
- [Merge branch 'feature/file-writer' into develop](http://github.com/hassankhan/Zepto/commit/37a560be6f10c3e87476aa6a7dc6b6775a11422f)
- [Cleaning up test class for ``Zepto\FileWriter``](http://github.com/hassankhan/Zepto/commit/d806aff2298d4a7e2ffa8a60f70225ac3b269281)
- [Disabling plugins now works without killing the whole app. Fixes #2](http://github.com/hassankhan/Zepto/commit/cbe74c365b2bc1c6634faa030416d01647d37092)
- [Added test case for ``Zepto\FileWriter``](http://github.com/hassankhan/Zepto/commit/62329e82e935a22f9b18d43dd14a2387467c06bf)
- [Refactored tests to use data providers](http://github.com/hassankhan/Zepto/commit/c38e373f0cb07f01c021665493ea209c6684ab3a)

#### 2013.12.10
- [Updated ``Zepto\FileWriter\MarkdownWriter`` to add description to template](http://github.com/hassankhan/Zepto/commit/bbf2753d496a0a2d15fdc3bd18bda2c2e76ce0eb)
- [Moved template to constructor](http://github.com/hassankhan/Zepto/commit/db41f4e19ad5656aae51728fb71abb040452f78a)

#### 2013.12.08
- [Merge branch 'feature/update-docs-n-tests' into feature/file-writer](http://github.com/hassankhan/Zepto/commit/d7a99251eb0aed2f4924268b27ac69b60a5d5365)
- [Updated README.md](http://github.com/hassankhan/Zepto/commit/a06d5b5ba642c713c40e04505f5fed79f94e382d)
- [Updated TODO.md](http://github.com/hassankhan/Zepto/commit/d37b6c50e78b134777e254542e0f1a148c0cea9e)
- [Renamed method ``Zepto::Zepto->load_files()`` to ``Zepto::Zepto->load_content()``](http://github.com/hassankhan/Zepto/commit/3360209c93bc6ba5e8ac0d1d2f5d0580f8b956cd)

#### 2013.11.28 - v0.5
- [[ci-skip] Bloody fix for Composer](http://github.com/hassankhan/Zepto/commit/8c7140f571fb8e9d9f747c8f69563cb754c8178e)
- [[ci-skip] Updated README.md](http://github.com/hassankhan/Zepto/commit/4dd157161fb2ed33b0c2297159f797b2b810523a)
- [Updated CHANGELOG.md](http://github.com/hassankhan/Zepto/commit/ef29fda7e473f763925a28bcf3196e9002d75191)
- [How embarrassing. All changelog links were pointing to an incorrect link. Fixed now.](http://github.com/hassankhan/Zepto/commit/fe175e45d4b020a52c0377cabe79bf9a86763d47)
- [Updated TODO.md](http://github.com/hassankhan/Zepto/commit/4e6e6d198c50092b8d59aecc29b2656605f00128)
- [Added tests for ``Zepto\Zepto``](http://github.com/hassankhan/Zepto/commit/3c31479d6b78016c8cad324d566a34f25992635f)
- [Added more comments and stuff](http://github.com/hassankhan/Zepto/commit/22ed769a08f77f28a0438a71a04e900262832d5e)
- [Added test class for ``Zepto\Zepto`` and fixed it so it didn’t break tests](http://github.com/hassankhan/Zepto/commit/b5c03868803f6b29c8ba09abcfe05140471f42d0)
- [Removed useless loaders, never gonna look back (hopefully)](http://github.com/hassankhan/Zepto/commit/3b23d0b54716e88a4d4d9a0f5895b5fdd9a8f161)
- [Moved tests under own namespace as per PSR-0](http://github.com/hassankhan/Zepto/commit/89c2fd2c9c951cfa1470e10c0a0bf6673ea4ee09)
- [Updated CHANGELOG.md and README.md](http://github.com/hassankhan/Zepto/commit/4669af33ea1b0b3997ea67d6bba01d8d7144bbc8)
- [Added more comments to ``Zepto\Zepto``](http://github.com/hassankhan/Zepto/commit/7b345e155805a68c0d140a0e725cd4f6168b0e7c)

#### 2013.11.18 - v0.4.1-3 feature/add-hooks
- [Merge branch 'feature/add-hooks' into develop](http://github.com/hassankhan/Zepto/commit/ae887fd1d64cd0849befdce682e7e81c83a48c71)
- [Added hooks to ``Zepto\Zepto``](http://github.com/hassankhan/Zepto/commit/f1024d0ef0cef8f4e7ad9ce819538372138e1a66)
- [Changed method signature of ``Zepto\PluginInterface::before_file_load()``](http://github.com/hassankhan/Zepto/commit/4f0dd44f6400cf87949c341739e483974133b146)
- [Merge branch 'develop' into feature/add-hooks](http://github.com/hassankhan/Zepto/commit/3515bc307b5b7e7e638cfd3b337db70081003889)
- [Cleaned up TODO.md](http://github.com/hassankhan/Zepto/commit/6bc826f312be81ef47fa5a6b30eec954ee57cfed)
- [Updated project version. Seriously, why didn’t I update this earlier?](http://github.com/hassankhan/Zepto/commit/91057a516453c9b288a1f723917238a3aac55385)
- [Added ``Zepto\FileLoader\PluginLoader`` to main app. Added ``after_file_load`` hook](http://github.com/hassankhan/Zepto/commit/f0332ead1c820588ba89f3d066e025c0a810d789)
- [Renamed option ``plugin_dir`` to ``plugins_dir``](http://github.com/hassankhan/Zepto/commit/656d105b17872897a4c49c8cf5dc75a24626ad53)
- [Changed method signature of ``Zepto\PluginInterface::after_file_load()``](http://github.com/hassankhan/Zepto/commit/42dc9aafb04212e3d75299610000bd8ddb7df8fb)
- [Fixed broken directory scanning for plugin files. Cleaned up ``Zepto\FileLoader\PluginLoader`` and test class](http://github.com/hassankhan/Zepto/commit/b8c247abb883653b857f3ba5a6b62d0847d83e6a)
- [Removed pico_plugin.php. Added OtherExamplePlugin.php](http://github.com/hassankhan/Zepto/commit/6e40692722f8b6a76dd5b03e8df6c7f7ac3109a3)
- [``Zepto\FileLoader\PluginLoader`` now returns an array of plugin names and instances.](http://github.com/hassankhan/Zepto/commit/d7e3d698e2a12f35c5570f018c6861e1c4b9ee5a)

#### 2013.11.17 - v0.4.1-2 feature/add-hooks
- [Added an option to config.php to enable/disable plugins](http://github.com/hassankhan/Zepto/commit/e669adf794111aabfe03ee6e8f1d95d35a69f0bf)
- [Added ``Zepto\FileLoader\PluginLoader`` and related test class. Updated ``Zepto\PluginInterface``, removed unnecessary hook. Added ``ExamplePlugin`` to show how to use ``Zepto\PluginInterface``](http://github.com/hassankhan/Zepto/commit/8af88be78387d4843567d88a91df6cf2de8619bc)
- [Updated Travis configuration to only include master and develop branches Fixes #1, updated README.md and documentation to reflect that. Updated composer.json](http://github.com/hassankhan/Zepto/commit/87ca48879161b69c255c1180c94e409f787cb4ec)
- [fix #1](http://github.com/hassankhan/Zepto/commit/0cd8717fd0ec8042decdd07a9ef4e3a6be1fc85d)
- [Updated composer.json (again)](http://github.com/hassankhan/Zepto/commit/971b1eb25c0b409d0dabbb3c9bf31a8e17c20f47)
- [Updated composer.json](http://github.com/hassankhan/Zepto/commit/60e6d090ec54527a2f345021e9eb9795df5f43c4)
- [More changes to composer.json in the vain hope that it will somehow work.](http://github.com/hassankhan/Zepto/commit/4bc50b2312059d3cc28bac520c62ec09ea81e6fb)

#### 2013.11.15 - v0.4.1-1 feature/add-hooks
- [Updated composer.json](http://github.com/hassankhan/Zepto/commit/61b7b5b48f5659a0afa00ec6ae4a225da0cdd0d4)
- [Merge branch 'develop'](http://github.com/hassankhan/Zepto/commit/695bfc337a3593042a266bb965fe1fa2e649a119)
- [Updated README.md. Updated composer.json to fix issues when installing from Composer](http://github.com/hassankhan/Zepto/commit/8f124cf1e096d75996265af8018b36da4c6babc5)
- [Updated CHANGELOG.md. Minor cleanup](http://github.com/hassankhan/Zepto/commit/6ca23940689350cda556228c4e1fe447e6a19ea9)
- [Changed ``Zepto\Plugin`` to be an interface](http://github.com/hassankhan/Zepto/commit/3f66b55556b00e413374a1693cfae41910ef0238)
- [[ci skip] Updated README.md and TODO.md](http://github.com/hassankhan/Zepto/commit/57c6d1535736d153e331857dd166936c3ba00bf0)
- [Updated README.md and style.css](http://github.com/hassankhan/Zepto/commit/a79f2ce0095bd5f38e06d654ad934937d85222a5)

#### 2013.11.14 - v0.4
- [Merge branch 'feature/moar-router-updates' into develop](http://github.com/hassankhan/Zepto/commit/beb3e36e1bd37aef9d4280503ed777e3e82c8387)
- [Massively refactor ``Zepto\Router`` and updated tests. Removed ``Zepto\Router::dispatch()``](http://github.com/hassankhan/Zepto/commit/61e1747769f3df3f2f6e70ab437aacfb43f5c2f0)
- [Updated ``Zepto\Router`` and test](http://github.com/hassankhan/Zepto/commit/2d82b48d25a091ebe6e66e66a7608dee9ef62193)
- [Merge branch 'feature/router-update' into develop](http://github.com/hassankhan/Zepto/commit/cd364121a248d67f162671c614173bb4f3c427ad)
- [Fixed 404 handling, updated tests](http://github.com/hassankhan/Zepto/commit/b955ef5d51649d635f5c3a55c4da1387674bc68b)
- [Removed ``default_route()`` method](http://github.com/hassankhan/Zepto/commit/cedef71d67c07dc85f408a0a5b1ee87e1df0a424)
- [Merge branch 'hotfix/broken-navigation' into develop](http://github.com/hassankhan/Zepto/commit/7cf156a1955cb99976a966ececf90257d285ce83)
- [Temporarily fixed navigation URLs to not break. Updated README.md](http://github.com/hassankhan/Zepto/commit/f7c82d9de4616c4dd40e163f9f4fe4b8d21e1135)
- [Cleaned up ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/f6434ae874e814cda55a70edfd9e12ea8e1d5261)
- [Updated test cases for ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/5f1ab43f15fdeb17ac64016ecc9d8a8a23d7091e)
- [[ci skip] Fixed typo in README.md](http://github.com/hassankhan/Zepto/commit/d27894457e89b096066fdac4d131bb2d824ddaa3)
- [Updated README.md](http://github.com/hassankhan/Zepto/commit/14989db2a7fd181439559949b359a2153d508847)
- [Fixed project name in composer.json to be Composer-compatible](http://github.com/hassankhan/Zepto/commit/61ae22b1604eb6d585786c49a9d8561f4c1772e2)
- [Cleaned up test class for ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/668f6c1a8e6967717a5acfa1e55550ae63f8abfc)
- [Replaced priorities with request methods in ``Zepto\Router``](http://github.com/hassankhan/Zepto/commit/88b7c5878058a1ed7d4f972c10945c7d302464be)

#### 2013.11.11 - v0.3
- [Added ``Zepto\Zepto::create_nav_links()`` to create navigation links](http://github.com/hassankhan/Zepto/commit/07d23516671c88d0ba7b44f94fd5104ad7f008dd)
- [Cleaned up config.php, added ‘.’ to ``content_ext``. Fixed file extension issue in ``Zepto\FileLoader``](http://github.com/hassankhan/Zepto/commit/0402d819470a5e3d6b0a976d709f76ea54e2ee19)
- [Cleaned up tests for ``Zepto\FileLoader\MarkdownLoader``](http://github.com/hassankhan/Zepto/commit/154c1a1725c2568b628fae19b3d763201c2e2aa4)
- [Added blocks to and updated base.twig](http://github.com/hassankhan/Zepto/commit/30a1ce17144aa8d462a5058113a570bdf3343007)
- [Updated ``Zepto\FileLoader\MarkdownLoader`` to not return empty key-values in ``meta`` and updated template check in ``Zepto\Zepto``](http://github.com/hassankhan/Zepto/commit/471a8a1860708e696a886e5bbf4f4b8061afeb84)
- [[ci skip] Updated path in Sublime Text project file Updated README.md](http://github.com/hassankhan/Zepto/commit/12c953547f13d8239902da4cad3e08981abf3bf7)
- [Initial commit, moved from https://github.com/hassankhan/Zepto/tree/develop](http://github.com/hassankhan/Zepto/commit/c3ae04c2566039956c1b08aad5ae8736ddb8a7fc)
- [Initial commit to new repo](http://github.com/hassankhan/Zepto/commit/41d2f6c9b26e0bf9de02daab0fc355ab8974c958)

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
