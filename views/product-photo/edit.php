<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$items = [
        '0' => 'Активный',
        '1' => 'Отключен',
        '2'=>'Удален'
    ];
    $params = [
        'prompt' => 'Выберите статус...'
    ];
?>
<h1>product-photo/edit</h1>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-lg-12">
	<h1>ProductPhotoForm form</h1>
	<?= $form->field($photo, 'path_fullsize')->textInput() ?>
	<?= $form->field($photo, 'path_thumbnail')->textInput() ?>
	<?= $form->field($photo, 'product_id')->dropDownList($products,$params);?>


	</div>
</div>
<div class="form-group">
<?= Html::submitButton('Create' , ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
