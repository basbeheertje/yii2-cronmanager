<?php

namespace basbeheertje\yii2\cronmanager\commands;

use Yii;
use basbeheertje\yii2\cronmanager\models\Task;
use mult1mate\crontab\TaskRunner;
use yii\console\Controller;

/**
 * Class CronController
 * @package console\commands
 */
class CronController extends Controller
{
    public $message;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Getter for options
     * @param string $actionId
     * @return array
     */
    public function options($actionId)
    {
        return $this->getOptions();
    }

    /**
     * Getter for all options aliassess
     * @return array
     */
    public function optionAliases()
    {
        return [
            'c' => 'check-tasks',
            'r' => 'run',
            'i' => 'index',
            'h' => 'help'
        ];
    }

    public function getOptions()
    {
        return [
            'index',
            'check-tasks',
            'run',
            'help',
        ];
    }

    /**
     * Action Index
     */
    public function actionIndex()
    {
        if (!isset($this->message)) {
            $this->message = "The following ";
            $this->message .= (string)implode("\r\n", $this->getOptions());
        }
        echo $this->message . "\n";
    }

    /**
     * Run tasks for this moment
     */
    public function actionRun(){
        $tasks = Task::getAll();
        if (is_null($tasks) || empty($tasks)) {
            return;
        }
        $CheckResult = TaskRunner::checkAndRunTasks($tasks);
        return $CheckResult;
    }

    /**
     * Check for tasks in the module
     */
    public function actionCheckTasks()
    {
        $tasks = Task::getAll();
        if (is_null($tasks) || empty($tasks)) {
            echo "There are no tasks!\r\n";
            return false;
        }
        echo "There are tasks!\r\n";
        return true;
    }

    /**
     * Help action
     */
    public function actionHelp()
    {
        echo 'Help';
    }
}
