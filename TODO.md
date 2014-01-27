To-Do
====

## Frontend
- Rewrite CSS to LESS
- Probably try and use Bootstrap
- Grunt/NPM support

## Documentation
- Router/routing
- Hooks
- Extending Zepto
- Fix headers for consistency

## Application
- [Add support for environments ``[production|dev]``](https://github.com/hassankhan/Zepto/issues/4)
- Abstract-ify Whoops
- Move ``index.php`` to ``public`` folder
- Check for PHP version and use newer functions where available

## Router
- Add functionality to allow for other HTTP verbs

## Templating Engine
- Add Twig extensions

## Plugins
- Add hooks to important parts of application by adding ``run_hooks()`` calls
    - [``after_config_load`` isn't working at the minute, need to decouple it some](https://github.com/hassankhan/Zepto/issues/5)

## [Tests](https://github.com/hassankhan/Zepto/issues?milestone=1&state=open)
- Write MORE unit tests
    - Add @dataProvider to ConsoleTest
- Maybe get some benchmarks up?
- [Add support for HHVM](https://github.com/hassankhan/Zepto/issues/3)

## ``zep``
- Make init wizard
- Make shortcuts for ``zep new`` like ``zep new -p Test`` for a new plugin called TestPlugin.php
