<?php

declare(strict_types=1);

use CraftCms\Cms\Database\Migration;
use CraftCms\Cms\Database\Table;
use CraftCms\Cms\ProjectConfig\ProjectConfig;
use CraftCms\SimpleText\Field;
use Illuminate\Support\Facades\DB;

/**
 * Points Simple Text fields saved by 3.x and earlier at the renamed field class.
 */
return new class extends Migration
{
    private const string OLD_TYPE = 'craft\simpletext\Field';

    public function up(): void
    {
        DB::table(Table::FIELDS)
            ->where('type', self::OLD_TYPE)
            ->update(['type' => Field::class]);

        $projectConfig = app(ProjectConfig::class);
        $muteEvents = $projectConfig->muteEvents;
        $projectConfig->muteEvents = true;

        try {
            $fieldConfigs = $projectConfig->find(fn (array $item) => ($item['type'] ?? null) === self::OLD_TYPE);

            foreach (array_keys($fieldConfigs) as $path) {
                $projectConfig->set("$path.type", Field::class);
            }
        } finally {
            $projectConfig->muteEvents = $muteEvents;
        }
    }
};
