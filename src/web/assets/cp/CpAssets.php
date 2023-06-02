<?php

namespace mangochutney\raiselydonationforms\web\assets\cp;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class CpAssets extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = __DIR__ . '/resources';

        $this->depends = [CpAsset::class];

        $this->js = [
            'field.js',
        ];
    }
}
