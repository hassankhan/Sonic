To-Do
====

## Project organisation
- [DONE] Rename ``themes`` to ``templates``, and all extensions inside to ``.twig``
- [DONE] Rename ``lib`` to ``library``
- [DONE] Remove ``themes`` folder

## Composer
- [DONE] Add [erusev/parsedown](https://github.com/erusev/parsedown) as Markdown parser
- [DONE] Make current library PSR-0 compatible

## Application
- Abstract-ify Whoops and Twig
- [DONE] Make navigation easier

## Router
- How to test router
    - [DONE] Add a ``get_routes()`` function to retrieve all registered routes
    - [DONE] Improve ``get_routes()`` to return single array containing all routes
    - [DONE] Instead of throwing an exception, check if route exists in table, if not, set 404 status code and display 404 page
- Add functionality to allow for
    - [DONE] GET
    - [DONE] POST
    - DELETE

## File Loader
- [DONE] Make it use Pimple
- [DONE] Make it search folders recursively
- [DONE] Make sure single files load
- [DONE] Make sure arrays of files load
- [DONE] Make sure post processing works

## Templating Engine
- [DONE] Add Twig
- Add Twig extensions

## Plugins
- Add hooks to important parts of application

## Tests
- [DONE] Set 'phpunit/phpunit' as dev-dependency
- Write unit tests

## Miscellanea
- Move ``index.php`` to ``public`` folder
