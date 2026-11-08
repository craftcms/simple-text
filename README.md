# Simple Text for Craft CMS

This plugin adds a new “Simple Text” field type to Craft, which provides a textarea that’s optimized for entering documentation.

## Textarea Features

- Uses a fixed-width font
- Automatically resizes

## Requirements

This plugin requires Craft CMS 6.0 or later and PHP 8.5 or later.

For Craft 4 and 5, use Simple Text 3.x. If you’re upgrading from Simple Text 3.x, see [UPGRADE.md](UPGRADE.md).

## Installation

You can install this plugin from the Plugin Store or with Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel and search for “Simple Text”. Then press **Install** in its modal window.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require craftcms/simple-text

# tell Craft to install the plugin
php artisan craft:plugin:install simple-text
```
