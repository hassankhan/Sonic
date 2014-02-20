/*
Title: Welcome
Description: This description will go in the meta description tag
*/

## Welcome to Zepto

Congratulations, you have successfully installed [Zepto](http://Zepto.dev7studios.com). Zepto is a stupidly simple, blazing fast, flat file CMS.

### Creating Content

Zepto is a flat-file CMS, so there's very little backend and no database to deal with. You simply create ``.md`` or ``.markdown`` files in the ``content`` folder and that becomes a page.
If you created folder within the content folder (e.g. ``content/sub``) and put an ``index.md`` inside it, you can access that folder at the URL ``http://yoursite.com/sub``. If you want another page within the sub-folder, simply create a text file with the corresponding name (e.g. ``content/sub/page.md``) and will be able to access it from the URL ``http://yoursite.com/sub/page``.
Below are some examples of content locations and their corresponding URLs:

|Physical Location                     |URL                         |
|--------------------------------------|----------------------------|
|&nbsp;content/index.md          &nbsp;|&nbsp;/               &nbsp;|
|&nbsp;content/sub/index.md      &nbsp;|&nbsp;/sub            &nbsp;|
|&nbsp;content/sub/page.md       &nbsp;|&nbsp;sub/page        &nbsp;|
|&nbsp;content/a/very/long/url.md&nbsp;|&nbsp;/a/very/long/url&nbsp;|

If a file cannot be found, a HTTP status 404 is sent and the 'Page Not Found' page is displayed.

#### Text File Markup

Text files are marked up using Markdown. They can also contain regular HTML. At the top of text files you can place a block comment and specify certain attributes of the page. For example:

    /*
    Title: Welcome
    Description: This description will go in the meta description tag
    Author: Joe Bloggs
    Date: 2013/01/01
    Robots: noindex,nofollow
    Template: index (allows you to use different templates in your theme)
    */
These values will be contained in the ``{{ meta }}`` variable in themes (see below).

### Templating

Zepto uses Twig for templating, and therefore assumes you already know how to use it. There's already a ``base.twig`` in the ``templates`` folder, but you can always put your own Twig templates in there.

You'll have the following variables available to you in every template:

    {{ config }} - Contains the values you set in config.php (e.g. {{ config.theme }} = "default")
    {{ base_dir }} - The path to your Zepto root directory
    {{ base_url }} - The URL to your Zepto site
    {{ site_title }} - Shortcut to the site title (defined in config.php)
    {{ meta }} - Contains the meta values from the current page
        {{ meta.title }}
        {{ meta.description }}
        {{ meta.author }}           // Should contain at least these three, the next three are optional
        {{ meta.date }}
        {{ meta.date_formatted }}
        {{ meta.robots }}
    {{ content }} - The content of the current page (after it has been processed through Markdown)
    {{ nav }} - Returns a HTML-formatted representation of the content folder, if you're using the ``NavGenPlugin``

You will also have access to the following helper functions:

    {{ url_for('name-of-file.md') }}    - Returns the fully-qualified URL for the file
    {{ link_for('name-of-file.md') }}   - Returns an &lt;a&gt; tag for the file

### Plugins

**coming soon**

### Config

You can override the default Zepto settings (and add your own custom settings) by editing config.php in the root Zepto directory. The config.php file lists all of the settings and their defaults. To override a setting, simply uncomment it in config.php and set your custom value.

### Documentation

For more help have a look at the Zepto documentation [here](https://github.com/hassankhan/Zepto/wiki/Documentation)
