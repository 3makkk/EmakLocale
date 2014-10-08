EmakLocale
=============
Created by Sven Friedemann

Introduction
------------

Automatic detection of locales from route query for Zend Framework 2.
EmakLocale adds a route strategy to the SlmLocale module.
For more information see [README](https://github.com/3makkk/SlmLocale)


Installation
------------

Add "emak/locale-route" to your to your composer.json file and update your dependencies. Enable "Locale" in your ```application.config.php```.

Usage
-----

Enable the route strategy in your configuration

```
'slm_locale' => array(
    'strategies' => array('route'),
),
```
If you already have a segment in your route named :lang your Locale shoud be detected.
Otherwise add a segment route to your config which contains a :lang segment or copy ``` EmakLocale\config\emak-locale.config.global.php``` to your autoload folder and edit it.






