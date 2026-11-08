<?php

declare(strict_types=1);

namespace CraftCms\SimpleText;

use CraftCms\Cms\Plugin\Plugin as BasePlugin;

/**
 * Simple Text plugin
 */
class Plugin extends BasePlugin
{
    public string $schemaVersion = '2.0.0';

    public string $minVersionRequired = '3.1.0';

    protected array $fieldTypes = [
        Field::class,
    ];
}
