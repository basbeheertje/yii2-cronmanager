<?php

namespace basbeheertje\yii2\cronmanager\jobs;

use basbeheertje\yii2\cronmanager\models\TaskRun;
use Yii;
use yii\base\BaseObject;

/**
 * This task could be enabled on the test api server to remove imported data and insert new random sample data
 */
class CronErrorChecker extends BaseObject
{

    /**
     * @todo describe
     * @todo make the time dynamic
     * @method execute
     */
    function execute()
    {
        /** @var TaskRun[] $failedRuns */
        $failedRuns = TaskRun::find()
            ->where(
                [
                    'status' => TaskRun::RUN_STATUS_ERROR,
                    'ts' => date('Y-m-d H:i:s', strtotime('-5 minutes'))
                ]
            )
            ->all();
        if ($failedRuns) {
            /** @var string $textBody */
            $textBody = "";
            foreach ($failedRuns as $failedRun) {
                /** @var TaskRun $failedRun */
                $textBody .= "The cronjob for command " . $failedRun->task->command . " has failed! Output is: " . $failedRun->task->output . "\r\n";
            }
            /** @var object $message */
            $message = Yii::$app->mailer->compose();
            $message->setTo(Yii::$app->params['adminEmail'])
                ->setSubject(Yii::t('cron', 'Failed cronjob'))
                ->setTextBody($textBody)
                ->send();
        }
    }
}