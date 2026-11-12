<?php

declare(strict_types=1);

use CraftCms\Cms\Entry\Elements\Entry;
use CraftCms\Cms\Field\FieldTypes;
use CraftCms\Cms\FieldLayout\FieldLayout;
use CraftCms\Cms\FieldLayout\FieldLayoutCompiler;
use CraftCms\Cms\FieldLayout\FieldLayoutTab;
use CraftCms\Cms\FieldLayout\LayoutElements\CustomField;
use CraftCms\Cms\Support\Facades\Elements;
use CraftCms\Cms\Support\Facades\Fields;
use CraftCms\Cms\Ui\UiContext;
use CraftCms\Cms\Ui\UiHtmlRenderer;
use CraftCms\Cms\Ui\UiResolver;
use CraftCms\SimpleText\Field;
use Symfony\Component\DomCrawler\Crawler;

it('registers the field type', function () {
    expect(app(FieldTypes::class)->types()->all())->toContain(Field::class);
});

it('saves values without trimming or reformatting them', function () {
    $entry = entryWithField(simpleTextField());
    $value = "  Leading spaces\n\tA tab\n\n<b>Not HTML</b> & co\n";

    $entry->setFieldValue('docs', $value);
    expect(Elements::saveElement($entry))->toBeTrue();

    $saved = Entry::find()->id($entry->id)->one();

    expect($saved->getFieldValue('docs'))->toBe($value);
});

it('renders a monospaced Behave.js textarea with the initial rows', function () {
    $field = new Field(['handle' => 'docs', 'uid' => 'field-docs', 'initialRows' => 7]);
    $layout = FieldLayout::make(Entry::class)
        ->tab('Content', fn (FieldLayoutTab $tab) => $tab->add(new CustomField($field, ['uid' => 'layout-docs'])));

    $payload = app(FieldLayoutCompiler::class)->compile($layout);
    $textarea = new Crawler(app(UiHtmlRenderer::class)->render($payload))->filter('craft-textarea');

    // The component that resources/js/simple-text.js registers
    expect($payload->nodes[0]->control?->component)->toBe('simple-text:textarea')
        ->and($textarea)->toHaveCount(1)
        ->and($textarea->attr('monospace'))->not->toBeNull()
        ->and($textarea->filter('textarea')->attr('rows'))->toBe('7');
});

it('shows the initial rows setting', function () {
    $field = new Field(['initialRows' => 9]);
    $context = new UiContext(namespace: 'settings');
    $html = app(UiHtmlRenderer::class)->render(app(UiResolver::class)->resolve($field->settingsUi($context), $context));

    expect(new Crawler($html)->filter('input[name="settings[initialRows]"]')->attr('value'))->toBe('9');
});

it('validates the initial rows setting', function (mixed $initialRows, bool $valid) {
    $field = Fields::createField([
        'type' => Field::class,
        'name' => 'Docs',
        'handle' => 'docs',
        'settings' => ['initialRows' => $initialRows],
    ]);

    expect(Fields::saveField($field))->toBe($valid);
})->with([
    'a number' => [6, true],
    'a numeric string from project config' => ['6', true],
    'zero' => [0, false],
    'a negative number' => [-2, false],
]);
