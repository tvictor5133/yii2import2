<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsParam */

$this->title = $model->param->name . ' ' . $model->value;
$this->params['breadcrumbs'][] = ['label' => 'Параметры продуктов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-param-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['Обновить', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['Удалить', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'product_id',
                'value' => $model->product->name
            ],
            [
                'attribute' => 'param_id',
                'value' => $model->param->name
            ],
            'value',
        ],
    ]) ?>

</div>
