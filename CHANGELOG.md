# Release Notes for Simple Text

## Unreleased

- Simple Text now requires Craft CMS 6.0 or later and PHP 8.5 or later, and runs natively on Craft 6 without the `craftcms/yii2-adapter` package.
- The plugin’s classes moved to the `CraftCms\SimpleText` namespace. Existing Simple Text fields are updated when you run `php artisan craft:up`. See [UPGRADE.md](UPGRADE.md).
- The field input is now Craft’s own monospaced textarea, which grows as you type, with Behave.js editing on top.
- With nothing selected, pressing <kbd>Tab</kbd> in the field now moves focus to the next control instead of inserting an indent. <kbd>Tab</kbd> and <kbd>Shift</kbd>+<kbd>Tab</kbd> still indent and outdent selected lines, and <kbd>Ctrl</kbd>/<kbd>Cmd</kbd>+<kbd>]</kbd> and <kbd>Ctrl</kbd>/<kbd>Cmd</kbd>+<kbd>[</kbd> indent and outdent the current line.
- The “Initial Rows” setting must now be a whole number of 1 or more.

## 3.1.0 - 2024-03-19

- Added Craft 5 compatibility.

## 3.0.0 - 2022-05-03

### Added
- Added Craft 4 compatibility.

## 2.0.2 - 2017-12-04

### Changed
- Loosened the Craft CMS version requirement to allow any 3.x version.

## 2.0.1 - 2017-09-28

### Changed
- Craft 3 Beta 23 compatibility.

## 2.0.0 - 2017-07-14

### Added
- Craft 3 compatibility.

## 1.1.0 - 2015-12-20

### Changed
- Updated to take advantage of new Craft 2.5 plugin features.

## 1.0.0 - 2014-07-24

### Added
- Initial release.
