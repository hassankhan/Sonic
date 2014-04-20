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
- MARKDOWN PLUGIN NEEDS TO BE MORE DECOUPLED
- Need to remove loads of 'md' strings, make it use the value from the settings
- [Add support for environments ``[production|dev]``](https://github.com/hassankhan/Zepto/issues/4)
- Move ``index.php`` to ``public`` folder
- Consider making ``$app`` protected, and using specific methods to access it
- Use output buffering
- Add bootstrap method to remove constructor bloat

## Router
- Add functionality to allow for other HTTP verbs

## [Tests](https://github.com/hassankhan/Zepto/issues?milestone=1&state=open)
- Write MORE unit tests
- Maybe get some benchmarks up?
