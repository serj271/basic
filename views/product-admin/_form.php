<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductForm */
/* @var $form ActiveForm */
?>
<div class="product-form">

    <?php $form = ActiveForm::begin([
		'action' => ['product-admin/edit'],
		'method' => 'post',
		'options'=>[
			'name'=>$name,
			'id'=>$name
		]
		
		
		]); ?>

        <?= $form->field($model, 'uri') ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'description') ?>
        <?= $form->field($model, 'visible') ?>
        <?= $form->field($model, 'created_at') ?>
        <?= $form->field($model, 'updated_at') ?>
        <?= $form->field($model, 'primary_photo_id') ?>
        <?= $form->field($model, 'id')->textInput(['value'=>$model->id,'readonly'=> true])?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- product-form -->
