<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsParam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-param-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group has-success">
        <label class="control-label" for="product_id">Продукт</label>
        <select id="product_id" class="form-control" name="ProductsParam[product_id]">
            <?= \app\components\MenuWidget::widget(['model' => $model, 'table' => 'product']) ?>
        </select>
    </div>


    <div class="form-group has-success">
        <label class="control-label" for="param_id">Продукт</label>
        <select id="param_id" class="form-control" name="ProductsParam[param_id]">
            <?= \app\components\MenuWidget::widget(['model' => $model, 'table' => 'param']) ?>
        </select>
    </div>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
