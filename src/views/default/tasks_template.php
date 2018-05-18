<?php

use yii\helpers\Url;

$menu = array(
    'index' => \Yii::t('cron', 'Tasks list'),
    'task-edit' => \Yii::t('cron', 'Add new/edit task'),
    'task-log' => \Yii::t('cron', 'Logs'),
    'export' => \Yii::t('cron', 'Import/Export'),
    'tasks-report' => \Yii::t('cron', 'Report'),
);
?>
<div class="col-lg-10">
    <h2><?php echo Yii::t('cron', 'Cron tasks manager'); ?></h2>
    <ul class="nav nav-tabs">
        <?php

        foreach ($menu as $m => $text) {
            $class = (isset($_GET['m']) && ($_GET['m'] == $m)) ? 'active' : '';

            ?>
            <li class="<?php echo $class; ?>">
                <a href="<?php echo Url::to(['default/' . $m]); ?>">
                    <?php echo $text; ?>
                </a>
            </li>
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
