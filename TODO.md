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

## Settings
- Make $settings array one-dimensional
- Add exclude filters for plugins/content

## Plugin
- Update NavGenPlugin to include subfolders
- Think of a better way to inject variables into route callback
- Move plugins to separate repo

## Application
- [Add support for environments ``[production|dev]``](https://github.com/hassankhan/Zepto/issues/4)
- Move ``index.php`` to ``public`` folder
- Consider making ``$app`` protected, and using specific methods to access it
- Use output buffering
- Add bootstrap method to remove constructor bloat

## Router
- Add functionality to allow for other HTTP verbs

## [Tests](https://github.com/hassankhan/Zepto/issues?milestone=1&state=open)
- Write MORE unit tests
    - Add @dataProvider to ConsoleTest
- Maybe get some benchmarks up?

## ``zep``
- Make init wizard
- Make shortcuts for ``zep new`` like ``zep new -p Test`` for a new plugin called TestPlugin.php
