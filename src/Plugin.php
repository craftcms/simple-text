<?php

declare(strict_types=1);

namespace CraftCms\SimpleText;

use CraftCms\Cms\Plugin\Plugin as BasePlugin;
use CraftCms\Cms\Ui\UiControlTypes;
use CraftCms\SimpleText\Ui\Controls\SimpleTextarea;

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

    protected array $scripts = [
        __DIR__.'/../resources/js/behave.min.js' => 'behave.min.js',
        __DIR__.'/../resources/js/simple-text.js' => 'simple-text.js',
    ];

    public function boot(UiControlTypes $controlTypes): void
    {
        $controlTypes->register(SimpleTextarea::class);
    }
}
