<?php
echo $this->render('tasks_template');
?>
<table class="table table-bordered">
    <tr>
        <th>
            <input type="checkbox" id="select_all">
        </th>
        <th><?php echo \Yii::t('app','ID'); ?></th>
        <th><?php echo \Yii::t('app','Time'); ?></th>
        <th><?php echo \Yii::t('app','Command'); ?></th>
        <th><?php echo \Yii::t('app','Status'); ?></th>
        <th><?php echo \Yii::t('app','Comment'); ?></th>
        <th><?php echo \Yii::t('app','Created'); ?></th>
        <th><?php echo \Yii::t('app','Updated'); ?></th>
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
                <a href="?r=tasks/task-edit&task_id=<?= $t->task_id ?>">Edit</a>
            </td>
            <td>
                <a href="?r=tasks/task-log&task_id=<?= $t->task_id ?>">Log</a>
            </td>
            <td>
                <a href="<?= $t->task_id ?>" class="run_task">Run</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<form class="form-inline">
    <div class="form-group">
        <label for="action"><?php echo \Yii::t('app','With selected'); ?></label>
        <select class="form-control" id="action">
            <option><?php echo \Yii::t('app','Enable'); ?></option>
            <option><?php echo \Yii::t('app','Disable'); ?></option>
            <option><?php echo \Yii::t('app','Delete'); ?></option>
            <option><?php echo \Yii::t('app','Run'); ?></option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" value="Apply" class="btn btn-primary" id="execute_action">
    </div>
</form>
<form class="form-inline">
    <h3><?php echo \Yii::t('app','Run custom task'); ?></h3>
    <div class="form-group">
        <label for="method"><?php echo \Yii::t('app','Methods'); ?></label>
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
        <label for="command"><?php echo \Yii::t('app','Command'); ?></label>
        <input type="text" class="form-control" id="command" name="command" placeholder="Controller::method" style="width: 300px;">
    </div>
    <input type="submit" value="Run" class="btn btn-primary" id="run_custom_task">
</form>
<div id="output_section" style="display: none;">
    <h3><?php echo \Yii::t('app','Task output'); ?></h3>
    <pre id="task_output_container"></pre>
</div>