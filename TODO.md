To-Do
====

## Project organisation

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
- Abstract-ify Whoops

## Router
- Add functionality to allow for
    - DELETE

## Templating Engine
- Add Twig extensions

## Plugins
- Make plugins Pimple Objects
- Remove all hardcoded paths from PluginLoader
- Add hooks to important parts of application by adding ``run_hooks()`` calls
    - ``after_config_load`` isn't working at the minute, need to decouple it some

## Tests
- Write MORE unit tests
    - Add @dataProvider to ConsoleTest
- Maybe get some benchmarks up?
- Add support for HHVM

## Miscellanea
- Move ``index.php`` to ``public`` folder
- Add support for environments ``[production|dev]``
- Check for PHP version and use newer functions where available
- Create a CLI-type tool for initial setup [IN PROGRESS]
