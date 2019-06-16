<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\jui\DatePicker;
?>
<h1>reservations/create ?></h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<div class="create">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'room_id') ?>
        <?= $form->field($model, 'customer_id')->dropDownList($items,[]) ?>
        <?= $form->field($model, 'price_per_day') ?>
        <?= $form->field($model, 'date_from')->widget(\yii\jui\DatePicker::classname(), [
			'language' => 'ru',
			'dateFormat' => 'dd/MM/yyyy',
		])   ?>
        <?= $form->field($model, 'date_to')->widget(\yii\jui\DatePicker::classname(), [
			'language' => 'ru',
			'dateFormat' => 'dd/MM/yyyy',
		])   ?>
      
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- create -->