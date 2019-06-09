<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Room */
/* @var $form yii\widgets\ActiveForm */
?>

<h1>customers/create-multiple-models</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>


<?php<div class="room-form">
	<?php $form = ActiveForm::begin(); ?>
		<div class="model">
			<?php for($k=0;$k<sizeof($models);$k++) { ?>
			<?php $model = $models[$k]; ?>
			<hr />
			<label>Model #<?php echo $k+1 ?></label>
			<?= $form->field($model, "[$k]name")->textInput() ?>
			<?= $form->field($model, "[$k]surname")->textInput() ?>
			<?= $form->field($model, "[$k]phone_number")->textInput() ?>
			<?php } ?>
			</div>
			<hr />
			<div class="form-group">
			<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>
?>