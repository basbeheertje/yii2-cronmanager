<?php

namespace basbeheertje\yii2\cronmanager\commands;

use basbeheertje\yii2\cronmanager\models\Task;
use mult1mate\crontab\TaskRunner;
use yii\console\Controller;

/**
 * Class CronController
 * @package console\commands
 */
class CronController extends Controller
{
    public function actionCheckTasks()
    {
        TaskRunner::checkAndRunTasks(Task::getAll());
    }
}
