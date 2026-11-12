<?php

declare(strict_types=1);

use CraftCms\Cms\Entry\Elements\Entry;
use CraftCms\Cms\Entry\Models\Entry as EntryModel;
use CraftCms\Cms\Entry\Models\EntryType;
use CraftCms\Cms\FieldLayout\Models\FieldLayout;
use CraftCms\Cms\Section\Models\Section;
use CraftCms\Cms\Support\Facades\EntryTypes;
use CraftCms\Cms\Support\Facades\Fields;
use CraftCms\SimpleText\Field;
use CraftCms\SimpleText\Tests\TestCase;

uses(TestCase::class)->in('Feature');

/**
 * Saves a Simple Text field with the given settings.
 *
 * @param  array<string, mixed>  $settings
 */
function simpleTextField(array $settings = [], string $handle = 'docs'): Field
{
    $field = Fields::createField([
        'type' => Field::class,
        'name' => 'Docs',
        'handle' => $handle,
        'settings' => $settings,
    ]);

    expect(Fields::saveField($field))->toBeTrue();

    return $field;
}

/**
 * Creates an entry whose entry type has the given field in its layout.
 */
function entryWithField(Field $field): Entry
{
    $type = EntryType::factory()
        ->withFieldLayout(FieldLayout::factory()->forField($field))
        ->create();
    EntryTypes::refreshEntryTypes();

    $section = Section::factory()->withEntryTypes($type)->create();

    return EntryModel::factory()->forSection($section)->forEntryType($type)->createElement(['title' => 'Docs page']);
}
