<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="form-group field-product-category_id has-success">
        <label class="control-label" for="product-category_id">Родительская категория</label>
        <select id="product-category_id" class="form-control" name="Product[category_id]">
            <option value="0">Самостоятельная категория</option>
            <?= \app\components\MenuWidget::widget(['model' => $model, 'table' => 'category']) ?>
        </select>
    </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'currency')->textInput() ?>

    <?= $form->field($model, 'url')->textInput() ?>

    <?php
    if (is_array($imgs)):
        echo '<div class="row">';
        foreach($imgs as $img):
            echo '<div class="col-xs-6 col-md-3">
                    <a href="#" data-id="' . $img->id . '" class="img-del"><span class="glyphicon glyphicon-remove"></span></a>
                    <a href="#" class="thumbnail"><img src="/web/images/' . $img->name . '"></a>
                  </div>';
        endforeach;
    echo '</div>';
    $imgs = new \app\models\UploadForm();
    endif;
    ?>

    <?= $form->field($imgs, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
