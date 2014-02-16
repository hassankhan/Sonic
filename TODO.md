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
- Move ``index.php`` to ``public`` folder
- Check for PHP version and use newer functions where available
- Consider making ``$app`` protected, and using specific methods to access it
- If a 404.md or 500.md file exists, then use that for those errors

## Router
- Add functionality to allow for other HTTP verbs
- Also, should request and response be protected or public?
-

## Templating Engine
- Add Twig extensions

## [Tests](https://github.com/hassankhan/Zepto/issues?milestone=1&state=open)
- Write MORE unit tests
    - Add @dataProvider to ConsoleTest
- Maybe get some benchmarks up?

## ``zep``
- Make init wizard
- Make shortcuts for ``zep new`` like ``zep new -p Test`` for a new plugin called TestPlugin.php
