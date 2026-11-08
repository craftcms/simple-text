<?php

declare(strict_types=1);

namespace CraftCms\SimpleText\Ui\Controls;

use CraftCms\Cms\Ui\Controls\Textarea;
use Override;

/**
 * The control panel’s textarea, rendered by `resources/js/simple-text.js`, which adds Behave.js editing.
 */
class SimpleTextarea extends Textarea
{
    #[Override]
    public function component(): string
    {
        return 'simple-text:textarea';
    }
}
