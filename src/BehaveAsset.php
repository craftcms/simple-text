<?php
/**
 * Created by PhpStorm.
 * User: makeilalundy
 * Date: 6/20/17
 * Time: 10:58 AM
 */

namespace craft\simpletext;


use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class BehaveAsset extends AssetBundle
{
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@bower/behave.js';

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