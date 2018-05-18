<?php

namespace basbeheertje\yii2\cronmanager\controllers;

use basbeheertje\yii2\cronmanager\assets\CronAsset;
use basbeheertje\yii2\cronmanager\models\Task;
use basbeheertje\yii2\cronmanager\models\TaskRun;
use mult1mate\crontab\TaskInterface;
use mult1mate\crontab\TaskLoader;
use mult1mate\crontab\TaskRunner;
use mult1mate\crontab\TaskManager;
use yii\web\Controller;
use yii\web\Application as WebApplication;
use Yii;

/**
 * Class CronController
 * @package basbeheertje\yii2\cronmanager\controllers
 */
class DefaultController extends Controller
{

    /**
     * CronController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param array $config
     */
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        if (Yii::$app instanceof WebApplication) {
            CronAsset::register($this->view);
        }
    }

    /**
     * @todo describe!
     * @param $file
     * @return null|string
     */
    function extract_namespace($file)
    {
        $ns = NULL;
        $handle = fopen($file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (strpos($line, 'namespace') === 0) {
                    $parts = explode(' ', $line);
                    $ns = rtrim(trim($parts[1]), ';');
                    break;
                }
            }
            fclose($handle);
        }
        return $ns;
    }

    /**
     * @todo describe!
     * @return array
     */
    protected function getMethods()
    {
        /** @var array $methods */
        $methods = [];

        /** @var array $folders */
        $folders = Yii::$app->getModule('cron')->methodfolders;

        if (is_string($folders)) {
            $folders = [
                $folders
            ];
        }
        if (is_array($folders)) {
            foreach ($folders as $folder) {
                /** @var string $folder */
                /** @var array $files */
                $files = glob($folder . "*.php");
                /** @var string $firstFile */
                $firstFile = $files[0];
                if ($firstFile) {
                    $namespace = $this->extract_namespace($firstFile) . '\\';
                    $methods = array_merge($methods, TaskLoader::getAllMethods($folder, $namespace));
                }
            }
        }
        return $methods;
    }

    /**
     * @todo describe!
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('tasks_list', array(
            'tasks' => Task::getList(),
            'methods' => $this->getMethods(),
        ));
    }

    /**
     * @todo describe!
     * @return string
     */
    public function actionExport()
    {
        return $this->render('export', array());
    }

    /**
     * @todo describe!
     */
    public function actionParseCrontab()
    {
        if (isset($_POST['crontab'])) {//@todo filter_output
            $result = TaskManager::parseCrontab($_POST['crontab'], new Task());//@todo filter_output
            echo json_encode($result);
        }
    }

    /**
     * @todo describe!
     */
    public function actionExportTasks()
    {
        if (isset($_POST['folder'])) {//@todo filter_output
            $tasks = Task::getList();
            $result = array();
            foreach ($tasks as $t) {
                $line = TaskManager::getTaskCrontabLine($t, $_POST['folder'], $_POST['php'], $_POST['file']);//@todo filter_output
                $result[] = nl2br($line);
            }
            echo json_encode($result);
        }
    }

    /**
     * @todo describe
     * @return string
     */
    public function actionTaskLog()
    {
        if(isset($_GET['task_run_id'])){
            $task_run_id = isset($_GET['task_run_id']) ? $_GET['task_run_id'] : null; //@todo use get from the framework with inputfiltering
            $model = TaskRun::find()->where(['task_run_id' => $_GET['task_run_id']])->one();//getLast($task_run_id);
            return $this->render('task_run_id', array('model' => $model));
        }
        $task_id = isset($_GET['task_id']) ? $_GET['task_id'] : null; //@todo use get from the framework with inputfiltering
        $runs = TaskRun::getLast($task_id);
        return $this->render('runs_list', array('runs' => $runs));
    }

    /**
     * @todo describe!
     */
    public function actionRunTask()
    {
        if (isset($_POST['task_id'])) {//@todo use input filtering
            $tasks = !is_array($_POST['task_id']) ? array($_POST['task_id']) : $_POST['task_id'];//@todo filter_output
            foreach ($tasks as $t) {
                $task = Task::findOne($t);
                /** @var Task $task */
                $output = TaskRunner::runTask($task);
                echo($output . '<hr>');
            }
        } elseif (isset($_POST['custom_task'])) {//@todo use input filtering
            $result = TaskRunner::parseAndRunCommand($_POST['custom_task']);//@todo filter_output
            echo ($result) ? 'success' : 'failed';
        } else {
            echo 'empty task id';
        }
    }

    /**
     * @todo describe!
     */
    public function actionGetDates()
    {
        $time = $_POST['time'];//@todo filter_output
        $dates = TaskRunner::getRunDates($time);
        if (empty($dates)) {
            echo 'Invalid expression';
            return;
        }
        echo '<ul>';
        foreach ($dates as $d) {
            /**
             * @var \DateTime $d
             */
            echo '<li>' . $d->format('Y-m-d H:i:s') . '</li>';
        }
        echo '</ul>';
    }

    /**
     * @todo describe!
     */
    public function actionGetOutput()
    {
        if (isset($_POST['task_run_id'])) {//@todo filter_output
            $run = TaskRun::findOne($_POST['task_run_id']);//@todo filter_output
            /**
             * @var TaskRun $run
             */

            echo htmlentities($run->getOutput());
        } else {
            echo 'empty task run id';
        }
    }

    /**
     * @todo describe!
     * @return string
     */
    public function actionTaskEdit()
    {
        if (isset($_GET['task_id'])) {//@todo filter_output
            $task = Task::findOne($_GET['task_id']);//@todo filter_output
        } else {
            $task = new Task();
        }
        /**
         * @var Task $task
         */
        if (!empty($_POST)) {//@todo filter_output
            $task = TaskManager::editTask($task, $_POST['time'], $_POST['command'], $_POST['status'], $_POST['comment']);//@todo filter_output
        }

        return $this->render('task_edit', array(
            'task' => $task,
            'methods' => $this->getMethods(),
        ));
    }

    /**
     * @todo describe!
     */
    public function actionTasksUpdate()
    {
        if (isset($_POST['task_id'])) {//@todo filter_output
            $tasks = Task::findAll($_POST['task_id']);//@todo filter_output
            foreach ($tasks as $t) {
                /**
                 * @var Task $t
                 */
                $action_status = array(
                    'Enable' => TaskInterface::TASK_STATUS_ACTIVE,
                    'Disable' => TaskInterface::TASK_STATUS_INACTIVE,
                    'Delete' => TaskInterface::TASK_STATUS_DELETED,
                );
                $t->setStatus($action_status[$_POST['action']]);
                $t->save();
            }
        }
    }

    /**
     * Action Task Report
     * @return string
     */
    public function actionTasksReport()
    {
        $date_begin = isset($_GET['date_begin']) ? $_GET['date_begin'] : date('Y-m-d', strtotime('-6 day'));//@todo filter_output
        $date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d');//@todo filter_output

        return $this->render('report', array(
            'report' => Task::getReport($date_begin, $date_end),
            'date_begin' => $date_begin,
            'date_end' => $date_end,
        ));
    }
}
