<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Параметры продуктов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-param-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать параметр продукта', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'product_id',
                'value' => function($data){
                    return $data->product->name;
                }

            ],
            [
                'attribute' => 'param_id',
                'value' => function($data){
                    return $data->param->name;
                }

            ],
            'value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
