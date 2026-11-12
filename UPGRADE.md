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
| `craft\simpletext\BehaveAsset` | Removed. Behave.js is loaded by the plugin’s control panel script. |

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

The field input is now Craft’s monospaced textarea, which grows as you type. Behave.js still closes brackets and quotes, indents new lines inside brackets and continues lists, but <kbd>Tab</kbd> works the way it does in Craft’s Markdown fields, so keyboard users can leave the field:

- With nothing selected, <kbd>Tab</kbd> and <kbd>Shift</kbd>+<kbd>Tab</kbd> move focus to the next or previous control instead of inserting or removing an indent.
- With text selected, <kbd>Tab</kbd> and <kbd>Shift</kbd>+<kbd>Tab</kbd> indent and outdent the selected lines, as before.
- <kbd>Ctrl</kbd>/<kbd>Cmd</kbd>+<kbd>]</kbd> and <kbd>Ctrl</kbd>/<kbd>Cmd</kbd>+<kbd>[</kbd> indent and outdent the current line or the selected lines.

### Field settings

“Initial Rows” must now be 1 or more. Saving a field with a lower value, or an empty one, shows a validation error. Decimals are rounded down, as with Craft’s other whole-number settings.

## Need help?

Open an issue at https://github.com/craftcms/simple-text/issues.
