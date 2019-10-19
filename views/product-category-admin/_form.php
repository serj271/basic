<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductCategoriesForm */
/* @var $form ActiveForm */
?>
<div class="product-categories-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'uri') ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'order') ?>
        <?= $form->field($model, 'description') ?>
        <?= $form->field($model, 'parent_id') ?>
        <?= $form->field($model, 'primary_photo_id') ?>
        <?= $form->field($model, 'image') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- product-categories-form -->
