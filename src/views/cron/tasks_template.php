<?php
$menu = array(
    'index' => \Yii::t('app','Tasks list'),
    'task-edit' => \Yii::t('app','Add new/edit task'),
    'task-log' => \Yii::t('app','Logs'),
    'export' => \Yii::t('app','Import/Export'),
    'tasks-report' => \Yii::t('app','Report'),
);
?>
<script src="manager_actions.js"></script>
<div class="col-lg-10">
    <h2><?php echo Yii::t('app', 'Cron tasks manager'); ?></h2>
    <ul class="nav nav-tabs">
        <?php

        foreach ($menu as $m => $text) {
            $class = (isset($_GET['m']) && ($_GET['m'] == $m)) ? 'active' : '';

        ?>
            <li class="<?php echo $class; ?>"><a href="?r=tasks/<?php echo $m; ?>"><?php echo $text; ?></a></li>
        <?php

        }

        ?>
    </ul>
    <br>
    <?php

    if (isset($content)) {
        echo $content;
    }

    ?>
</div>
