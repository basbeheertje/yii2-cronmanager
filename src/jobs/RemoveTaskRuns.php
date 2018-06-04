<?php

namespace basbeheertje\yii2\cronmanager\jobs;

use basbeheertje\yii2\cronmanager\models\TaskRun;
use Yii;
use yii\base\BaseObject;

/**
 * This task could be enabled on the test api server to remove imported data and insert new random sample data
 */
class RemoveTaskRuns extends BaseObject
{

    /**
     * @todo describe
     * @todo make the time dynamic
     * @method execute
     */
    function execute()
    {
        /** @var TaskRun[] $toRemove */
        $toRemove = TaskRun::find()
            ->where(['<', 'ts', date('Y-m-d H:i:s', strtotime('-5 hours'))])
            ->all();
        if ($toRemove) {
            foreach ($toRemove as $removable) {
                /** @var TaskRun $removable */
                $removable->delete();
            }
        }
        return true;
    }
}