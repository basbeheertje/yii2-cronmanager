<?php
echo $this->render('tasks_template');
?>
<table class="table table-bordered">
    <tr>
        <th><?php echo \Yii::t('app','ID'); ?></th>
        <th><?php echo \Yii::t('app','Task ID'); ?></th>
        <th><?php echo \Yii::t('app','Command'); ?></th>
        <th><?php echo \Yii::t('app','Status'); ?></th>
        <th><?php echo \Yii::t('app','Time'); ?></th>
        <th><?php echo \Yii::t('app','Started'); ?></th>
        <th></th>
    </tr>
    <?php foreach ($runs as $r):
        /**
         * @var \app\models\TaskRun $r
         */
        ?>
        <tr>
            <td><?= $r['task_run_id'] ?></td>
            <td><?= $r['task_id'] ?> </td>
            <td><?= $r['command'] ?></td>
            <td><?= $r['status'] ?></td>
            <td><?= $r['execution_time'] ?></td>
            <td><?= $r['ts'] ?></td>
            <td>
                <?php if (!empty($r['output'])): ?>
                    <a href="<?= $r['task_run_id'] ?>" data-toggle="modal" data-target="#output_modal" class="show_output">
						<?php echo \Yii::t('app','Show output'); ?>
					</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="modal fade" tabindex="-1" role="dialog" id="output_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo \Yii::t('app','Task run output'); ?></h4>
            </div>
            <div class="modal-body">
                <pre id="output_container"><?php echo \Yii::t('app','Loading...'); ?></pre>
            </div>
        </div>
    </div>
</div>