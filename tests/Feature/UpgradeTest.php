<?php

declare(strict_types=1);

use CraftCms\Cms\Database\Table;
use CraftCms\Cms\Field\PlainText;
use CraftCms\Cms\ProjectConfig\ProjectConfig;
use CraftCms\Cms\Support\Facades\Fields;
use CraftCms\SimpleText\Field;
use Illuminate\Support\Facades\DB;

it('points fields saved by Simple Text 3 at the new field class', function () {
    $field = simpleTextField(['initialRows' => 6]);
    $other = Fields::createField(['type' => PlainText::class, 'name' => 'Other', 'handle' => 'other']);
    expect(Fields::saveField($other))->toBeTrue();

    // Store the field the way 3.x did
    $projectConfig = app(ProjectConfig::class);
    $projectConfig->muteEvents = true;
    $projectConfig->set("fields.$field->uid.type", 'craft\simpletext\Field');
    $projectConfig->muteEvents = false;
    DB::table(Table::FIELDS)->where('id', $field->id)->update(['type' => 'craft\simpletext\Field']);

    (require dirname(__DIR__, 2).'/database/migrations/2026_11_08_000000_update_simple_text_field_type.php')->up();
    Fields::refreshFields();

    expect(DB::table(Table::FIELDS)->where('id', $field->id)->value('type'))->toBe(Field::class)
        ->and($projectConfig->get("fields.$field->uid.type"))->toBe(Field::class)
        ->and($projectConfig->get("fields.$other->uid.type"))->toBe(PlainText::class)
        ->and(Fields::getFieldByHandle('docs'))->toBeInstanceOf(Field::class)
        ->and(Fields::getFieldByHandle('docs')->initialRows)->toBe(6);
});
