<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   MIT
 */

namespace craft\simpletext;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class BehaveAsset extends AssetBundle
{
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = dirname(__DIR__).'/lib/behave.js';

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'behave'.$this->dotJs(),
        ];

        parent::init();
    }
}
