<?php

namespace basbeheertje\yii2\cronmanager\assets;

use yii\web\AssetBundle;

/**
 * Class CronAsset
 * @package basbeheertje\yii2\cronmanager\assets
 */
class CronAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/manager_actions.js',
    ];
}