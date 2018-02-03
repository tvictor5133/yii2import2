<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить продукт?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'category_id',
                'value' => function($data){
                    return $data->category_id ? $data->category->name : "Самостоятельная категория";
                }
            ],
            'name',
            'description',
            'price',
            [
                'attribute' => 'image',
                'value' => function($model){
                    $res = '<div class="row">';
                    foreach($model->image as $image){
                        $res .= '<div class="col-xs-6 col-md-3"><a href="#" class="thumbnail"><img src="/web/images/' . $image->name . '"></a></div>';
                    }
                    $res .= '</div>';
                    return $res;
                },
                'format' => 'html'
            ]
        ],
    ]) ?>

</div>
