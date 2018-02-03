<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProductsParam */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Параметры продуктов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-param-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
