<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model basbeheertje\yii2\cronmanager\models\TaskRun */

$this->title = $model->task_run_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cron', 'Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taskrun-view">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'task_run_id',
            'task_id',
            'status',
            'execution_time',
            'ts',
            'output',
        ],
    ]);

    ?>
</div>
