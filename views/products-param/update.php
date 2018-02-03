<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsParam */

$this->title = 'Обновить значение параметра';
$this->params['breadcrumbs'][] = ['label' => 'Параметры продуктов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->param->name . ' ' . $model->value, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="products-param-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
