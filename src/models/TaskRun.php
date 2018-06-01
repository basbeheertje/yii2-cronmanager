<?php

namespace basbeheertje\yii2\cronmanager\models;

use mult1mate\crontab\TaskRunInterface;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * @todo describe
 * @property int $task_run_id
 * @property int $task_id
 * @property string $status
 * @property string $output
 * @property int $execution_time
 * @property string $ts
 */
class TaskRun extends ActiveRecord implements TaskRunInterface
{
    /**
     * @todo describe
     * @return string
     */
    public static function tableName()
    {
        return 'task_runs';
    }

    /**
     * @todo describe
     * @param null $task_id
     * @param int $count
     * @return array
     */
    public static function getLast($task_id = null, $count = 100)
    {
        $db = (new Query())
            ->select('task_runs.*, tasks.command')
            ->from(self::tableName())
            ->join('LEFT JOIN', 'tasks', 'tasks.task_id = task_runs.task_id')
            ->orderBy('task_runs.task_run_id desc')
            ->limit($count);
        if ($task_id) {
            $db->where('task_runs.task_id=:task_id', array(':task_id' => $task_id));
        }

        return $db->all();
    }

    /**
     * @todo describe
     * @return bool
     */
    public function saveTaskRun()
    {
        return $this->save();
    }

    /**
     * @todo describe
     * @return int
     */
    public function getTaskRunId()
    {
        return $this->task_run_id;
    }

    /**
     * @todo describe
     * @return int
     */
    public function getTaskId()
    {
        return $this->task_id;
    }

    /**
     * @todo describe
     * @param int $task_id
     */
    public function setTaskId($task_id)
    {
        $this->task_id = $task_id;
    }

    /**
     * @todo describe
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @todo describe
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @todo describe
     * @return int
     */
    public function getExecutionTime()
    {
        return $this->execution_time;
    }

    /**
     * @todo describe
     * @param int $execution_time
     */
    public function setExecutionTime($execution_time)
    {
        $this->execution_time = $execution_time;
    }

    /**
     * @todo describe
     * @return string
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * @todo describe
     * @param string $ts
     */
    public function setTs($ts)
    {
        $this->ts = $ts;
    }

    /**
     * @todo describe
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @todo describe
     * @param string $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }
}
