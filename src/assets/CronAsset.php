<?php

namespace basbeheertje\yii2\cronmanager\assets;

use yii\web\AssetBundle;

/**
 * Class CronAsset
 * @package basbeheertje\yii2\cronmanager\assets
 */
class CronAsset extends AssetBundle
{
    public $sourcePath = '@vendor/basbeheertje/yii2-cronmanager/src/web';
    public $js = [
        'js/manager_actions.js',
    ];
}