<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   MIT
 */

namespace craft\simpletext;

use Craft;
use craft\base\ElementInterface;
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
    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * Returns the field's settings HTML.
     *
     * @return string|null
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplateMacro('_includes/forms', 'textField', [
            [
                'label' => Craft::t('simple-text', 'Initial Rows'),
                'id' => 'initialRows',
                'name' => 'initialRows',
                'value' => $this->initialRows,
                'size' => 3,
                'errors' => $this->getErrors('initialRows'),
            ]
        ]);
    }

    /**
     * Returns the field's input HTML.
     *
     * @param mixed                 $value
     * @param ElementInterface|null $element
     *
     * @return string
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        Craft::$app->getView()->registerAssetBundle(BehaveAsset::class);
        Craft::$app->getView()->registerJs("new Behave({ textarea: document.getElementById('{$namespacedId}') });");

        return Craft::$app->getView()->renderTemplateMacro('_includes/forms', 'textarea', [
            [
                'id' => $id,
                'name' => $this->handle,
                'value' => $value,
                'class' => 'nicetext fullwidth code',
                'rows' => $this->initialRows,
            ]
        ]);
    }

}
