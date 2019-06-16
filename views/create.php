<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReservationForm */
/* @var $form ActiveForm */
?>
<div class="create">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'room_id') ?>
        <?= $form->field($model, 'customer_id') ?>
        <?= $form->field($model, 'price_per_day') ?>
        <?= $form->field($model, 'date_from') ?>
        <?= $form->field($model, 'date_to') ?>
        <?= $form->field($model, 'reservation_date') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- create -->
