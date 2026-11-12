<?php

declare(strict_types=1);

namespace CraftCms\SimpleText;

use CraftCms\Cms\Field\Field as BaseField;
use CraftCms\Cms\Field\FieldContext;
use CraftCms\Cms\Ui\Contracts\Control;
use CraftCms\Cms\Ui\Controls\Number;
use CraftCms\Cms\Ui\Nodes\Field as UiField;
use CraftCms\Cms\Ui\Ui;
use CraftCms\Cms\Ui\UiContext;
use CraftCms\SimpleText\Ui\Controls\SimpleTextarea;
use Override;

use function CraftCms\Cms\t;

/**
 * Simple Text field type: a monospaced, auto-growing textarea with Behave.js editing.
 */
class Field extends BaseField
{
    /** The number of rows the textarea shows before it grows. */
    public int $initialRows = 4;

    #[Override]
    public static function displayName(): string
    {
        return t('Simple Text', category: 'simple-text');
    }

    #[Override]
    public static function phpType(): string
    {
        return 'string|null';
    }

    #[Override]
    public function getRules(): array
    {
        return array_merge(parent::getRules(), [
            'initialRows' => ['required', 'integer', 'min:1'],
        ]);
    }

    #[Override]
    public function settingsUi(UiContext $context = new UiContext): Ui
    {
        return Ui::make([
            UiField::make(t('Initial Rows', category: 'simple-text'))
                ->control(Number::make('initialRows')
                    ->value($this->initialRows)
                    ->min(1)
                    ->size(3)),
        ]);
    }

    #[Override]
    public function uiControl(FieldContext $context): Control
    {
        return SimpleTextarea::make($context->path)
            ->value($context->value)
            ->rows($this->initialRows)
            ->monospace();
    }
}
