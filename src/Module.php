<?php

namespace basbeheertje\yii2\cronmanager;

use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;
use yii\web\Application as WebApplication;
use yii\web\GroupUrlRule;

/**
 * Cronmanagement Module
 *
 * @property \yii\i18n\Formatter $formatter
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $layout = 'main';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'basbeheertje\yii2\cronmanager\controllers';
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'cron/index';

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof WebApplication) {
            $app->urlManager->addRules([[
                'class' => GroupUrlRule::class,
                'prefix' => $this->id,
                'rules' => [
                    'stats' => 'stat/index',
                    'jobs' => 'job/index',
                    'job/<id:\d+>/<action\w+>' => 'job/view-<action>',
                    'workers' => 'worker/index',
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action\w+>' => '<controller>/<action>',
                ],
            ]], false);
        } else {
            throw new InvalidConfigException('The module must be used for web application only.');
        }
    }
}
