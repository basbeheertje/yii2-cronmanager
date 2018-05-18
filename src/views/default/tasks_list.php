<?php

use yii\helpers\Url;

echo $this->render('tasks_template');
?>
<table class="table table-bordered">
    <tr>
        <th>
            <input type="checkbox" id="select_all">
        </th>
        <th><?php echo Yii::t('cron', 'ID'); ?></th>
        <th><?php echo Yii::t('cron', 'Time'); ?></th>
        <th><?php echo Yii::t('cron', 'Command'); ?></th>
        <th><?php echo Yii::t('cron', 'Status'); ?></th>
        <th><?php echo Yii::t('cron', 'Comment'); ?></th>
        <th><?php echo Yii::t('cron', 'Created'); ?></th>
        <th><?php echo Yii::t('cron', 'Updated'); ?></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <?php
    foreach ($tasks as $t):
        /**
         * @var \app\models\Task $t
         */
        $status_class = (\mult1mate\crontab\TaskInterface::TASK_STATUS_ACTIVE == $t->status) ? '' : 'text-danger';
        ?>
        <tr>
            <td>
                <input type="checkbox" value="<?= $t->task_id ?>" class="task_checkbox">
            </td>
            <td><?= $t->task_id ?></td>
            <td><?= $t->time ?></td>
            <td><?= $t->command ?></td>
            <td class="<?= $status_class ?>"><?= $t->status ?></td>
            <td><?= $t->comment ?></td>
            <td><?= $t->ts ?></td>
            <td><?= $t->ts_updated ?></td>
            <td>
                <a href="<?php echo Url::to(['default/task-edit', 'task_id' => $t->task_id]); ?>"><?php echo Yii::t('cron', 'Edit'); ?></a>
            </td>
            <td>
                <a href="<?php echo Url::to(['default/task-log', 'task_id' => $t->task_id]); ?>"><?php echo Yii::t('cron', 'Log'); ?></a>
            </td>
            <td>
                <a href="<?php echo $t->task_id; ?>" class="run_task"><?php echo Yii::t('cron', 'Run'); ?></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<form class="form-inline">
    <div class="form-group">
        <label for="action"><?php echo Yii::t('cron', 'With selected'); ?></label>
        <select class="form-control" id="action">
            <option><?php echo Yii::t('cron', 'Enable'); ?></option>
            <option><?php echo Yii::t('cron', 'Disable'); ?></option>
            <option><?php echo Yii::t('cron', 'Delete'); ?></option>
            <option><?php echo Yii::t('cron', 'Run'); ?></option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" value="Apply" class="btn btn-primary" id="execute_action">
    </div>
</form>
<form class="form-inline">
    <h3><?php echo Yii::t('cron', 'Run custom task'); ?></h3>
    <div class="form-group">
        <label for="method"><?php echo \Yii::t('cron', 'Methods'); ?></label>
        <select class="form-control" id="method">
            <option></option>
            <?php foreach ($methods as $class => $class_methods): ?>
                <optgroup label="<?= $class ?>">
                    <?php foreach ($class_methods as $m): ?>
                        <option value="<?= $class . '::' . $m . '()' ?>"><?= $m ?></option>
                    <?php endforeach; ?>
                </optgroup>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="command"><?php echo \Yii::t('cron', 'Command'); ?></label>
        <input type="text" class="form-control" id="command" name="command" placeholder="Controller::method" style="width: 300px;">
    </div>
    <input type="submit" value="Run" class="btn btn-primary" id="run_custom_task">
</form>
<div id="output_section" style="display: none;">
    <h3><?php echo Yii::t('cron', 'Task output'); ?></h3>
    <pre id="task_output_container"></pre>
</div>