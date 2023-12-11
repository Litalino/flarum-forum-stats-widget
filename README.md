# Forum Stats Widget

![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square) [![Latest Stable Version](https://img.shields.io/packagist/v/litalino/flarum-forum-stats-widget.svg?style=flat-square)](https://packagist.org/packages/litalino/flarum-forum-stats-widget) [![Total Downloads](https://img.shields.io/packagist/dt/litalino/flarum-forum-stats-widget.svg?style=flat-square)](https://packagist.org/packages/litalino/flarum-forum-stats-widget) [![donate](https://img.shields.io/badge/donate-buy%20me%20a%20coffee-%23ffde39?style=flat-square)](https://www.buymeacoffee.com/sycho)

A [Flarum](http://flarum.org) extension. Forum Statistics Widget.

PLugin Developer: afrux/forum-stats-widget

PLugin Clone Co-development: Litalino/flarum-forum-stats-widget

![Forum Stats Widget](https://github.com/Litalino/flarum-forum-stats-widget/assets/99712477/02938edd-511e-4ccc-b455-4ce5cc0a2f8c)


## Installation

This will also install [Forum Widgets Core](https://github.com/afrux/forum-widgets-core) as it relies on it.

Install with composer:

```sh
composer require litalino/flarum-forum-stats-widget:"*"
```

## Updating

```sh
composer update litalino/flarum-forum-stats-widget:"*"
php flarum migrate
php flarum cache:clear
```
or 

```sh
composer update litalino/flarum-forum-stats-widget:"*" --with-dependencies
php flarum migrate
php flarum cache:clear
```

## Updating from afrux

This extension replaces [Forum Stats Widget](https://packagist.org/packages/afrux/forum-stats-widget).

**Please backup your data before attempting the update!**

You can upgrade from any of the older versions of the Forum Stats Widget.

Then upgrade from the old extension to the new one:

```sh
composer remove afrux/forum-stats-widget
composer require litalino/flarum-forum-stats-widget
```

## Links

- [Packagist](https://packagist.org/packages/litalino/flarum-forum-stats-widget)
- [GitHub](https://github.com/litalino/flarum-forum-stats-widget)
- [Discuss](https://discuss.flarum.org/d/10000-flarum-forum-stats-widget)
