<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license MIT
 */

namespace craft\simpletext;

use Craft;
use craft\base\ElementInterface;
use craft\helpers\Cp;
use yii\db\Schema;

/**
 * Simple Text field type
 */
class Field extends \craft\base\Field
{
    /**
     * @var int
     */
    public $initialRows = 4;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('simple-text', 'Simple Text');
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): array|string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * Returns the field's settings HTML.
     *
     * @return string|null
     */
    public function getSettingsHtml(): ?string
    {
        return Cp::textFieldHtml([
            'label' => Craft::t('simple-text', 'Initial Rows'),
            'id' => 'initialRows',
            'name' => 'initialRows',
            'value' => $this->initialRows,
            'size' => 3,
            'errors' => $this->getErrors('initialRows'),
        ]);
    }

    /**
     * Returns the field's input HTML.
     *
     * @param mixed $value
     * @param ElementInterface|null $element
     * @return string
     */
    public function getInputHtml(mixed $value, ?\craft\base\ElementInterface $element = null): string
    {
        $id = $this->getInputId();
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        Craft::$app->getView()->registerAssetBundle(BehaveAsset::class);
        Craft::$app->getView()->registerJs("new Behave({ textarea: document.getElementById('{$namespacedId}') });");

        return Cp::textareaFieldHtml([
            'id' => $id,
            'name' => $this->handle,
            'value' => $value,
            'class' => 'nicetext fullwidth code',
            'rows' => $this->initialRows,
        ]);
    }
}
