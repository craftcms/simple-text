# Upgrading to Simple Text 4.0 (Craft 6)

Simple Text 4.0 is a native Craft 6 plugin. This guide lists what changed from 3.x and what to update in your project.

## Requirements

- Craft CMS 6.0 or later
- PHP 8.5 or later
- The `craftcms/yii2-adapter` package is not needed.

## Upgrade steps

1. Upgrade your project to Craft 6 first.
2. Update the plugin: `composer require craftcms/simple-text:^4.0`.
3. Run `php artisan craft:up`. This points your existing Simple Text fields at the new field class, in the database and in project config.
4. If you use project config, commit the updated YAML files.

Field settings and saved values are kept, and templates keep working without changes: `{{ entry.myField }}` still outputs the saved text as a string.

## Breaking changes

### Classes and namespaces

| Before | After |
| --- | --- |
| `craft\simpletext\Plugin` | `CraftCms\SimpleText\Plugin` |
| `craft\simpletext\Field` | `CraftCms\SimpleText\Field` |
| `craft\simpletext\BehaveAsset` | Removed. The field uses Craft’s own textarea. |

Update any code that refers to the old class names, such as type checks:

```php
// Before
if ($field instanceof \craft\simpletext\Field) {
    // ...
}

// After
if ($field instanceof \CraftCms\SimpleText\Field) {
    // ...
}
```

### Field input

The field input is now Craft’s monospaced textarea, which grows as you type. Behave.js was removed, so:

- Pressing <kbd>Tab</kbd> moves focus to the next control instead of inserting an indent. Paste or type spaces to indent. Tabs in saved values are kept.
- Brackets and quotes are no longer closed automatically.

### Field settings

“Initial Rows” must now be a whole number of 1 or more. Saving a field with any other value shows a validation error.

## Need help?

Open an issue at https://github.com/craftcms/simple-text/issues.
