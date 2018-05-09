<?php
/**
 * @author mult1mate
 * Date: 21.12.15
 * Time: 0:56
 * @var Task $task
 * @var array $methods
 */
echo $this->render('tasks_template');
?>
<form method="post">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="method"><?php echo \Yii::t('cron','Methods'); ?></label>
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
            <label for="command"><?php echo \Yii::t('cron','Command'); ?></label>
            <input type="text" class="form-control" id="command" name="command" placeholder="Controller::method"
                   value="<?= $task->command ?>">
        </div>
        <div class="form-group">
            <label for="status"><?php echo \Yii::t('cron','Status'); ?></label>
            <select name="status" class="form-control" id="status">
                <option value="active"><?php echo \Yii::t('cron','Active'); ?></option>
                <option value="inactive"<?php if ('inactive' == $task->status) echo ' selected' ?>><?php echo \Yii::t('app','Inactive'); ?></option>
            </select>
        </div>
        <div class="form-group">
            <label for="comment"><?php echo \Yii::t('cron','Comment'); ?></label>
            <input type="text" class="form-control" id="comment" name="comment" value="<?= $task->comment ?>">
        </div>

        <?php if ($task->task_id): ?>
            <input type="hidden" name="task_id" value="<?= $task->task_id ?>">
        <?php endif; ?>

        <input type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>"/>
        <button type="submit" class="btn btn-primary"><?php echo \Yii::t('cron','Save'); ?></button>

    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="times"><?php echo \Yii::t('cron','Predefined intervals'); ?></label>
            <select class="form-control" id="times" style="width: 200px;">
                <option></option>
                <option value="* * * * *">Minutely</option>
                <option value="0 * * * *">Hourly</option>
                <option value="0 0 * * *">Daily</option>
                <option value="0 0 * * 0">Weekly</option>
                <option value="0 0 1 * *">Monthly</option>
                <option value="0 0 1 1 *">Yearly</option>
            </select>
        </div>
        <div class="form-group">
            <label for="time"><?php echo \Yii::t('cron','Time'); ?></label>
            <input type="text" class="form-control" id="time" name="time" placeholder="* * * * *" value="<?= $task->time ?>" style="width: 200px;">
        </div>
    <pre>
*    *    *    *    *
-    -    -    -    -
|    |    |    |    |
|    |    |    |    |
|    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
|    |    |    +---------- month (1 - 12)
|    |    +--------------- day of month (1 - 31)
|    +-------------------- hour (0 - 23)
+------------------------- min (0 - 59)
    </pre>
        <h4><?php echo \Yii::t('cron','Next runs'); ?></h4>
        <div id="dates_list"></div>
    </div>
</form>