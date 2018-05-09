<?php

namespace basbeheertje\yii2\cronmanager;

use yii\base\BootstrapInterface;
use yii\web\Application as WebApplication;
use yii\console\Application as ConsoleApp;
use yii\web\GroupUrlRule;

/**
 * Cronmanagement Module
 * @property array $methodfolders
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $layout = '@app/views/layouts/main';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'basbeheertje\yii2\cronmanager\controllers';

    /**
     * @inheritdoc
     */
    public $defaultRoute = 'default/index';

    /**
     * @var string
     */
    public $defaultController = 'default';

    /**
     * @var array
     */
    public $methodfolders = ['@app/models'];

    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Make sure to register the base folder as alias as well or things like assets won't work anymore
        \Yii::setAlias('@basbeheertje/yii2/cronmanager', __DIR__);
        if ($app instanceof WebApplication) {
            $app->urlManager->addRules([[
                'class' => GroupUrlRule::class,
                'prefix' => $this->id,
                'rules' => [
                    'cron' => 'cron/index',
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action\w+>' => '<controller>/<action>',
                ],
            ]], false);
        }
        if ($app instanceof ConsoleApp) {
            $app->controllerMap[$this->getCommandId()] = [
                    'class' => $this->getCommandClass(),
                ] + $this->getCommandOptions();
        }
    }

    /**
     * Getter for CommandId
     * @return string
     */
    public function getCommandId()
    {
        return "cron";
    }

    /**
     * Getter for CommandClass
     * @return string
     */
    public function getCommandClass()
    {
        return "basbeheertje\yii2\cronmanager\commands\CronController";
    }

    /**
     * Getter for commandoptions
     * @return array
     */
    public function getCommandOptions()
    {
        return [];
    }
}
