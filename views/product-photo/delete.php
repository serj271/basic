<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

    $params = [
        'prompt' => 'Выберите статус...'
    ];
?>
<h1>product-photo/delete</h1>
<img src="<?php echo Yii::getAlias('@web').'/'.$photo['path_thumbnail'] ?>" width=<?=$width?> height=<?=$height?>> 
<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-lg-12">
	<h1>ProductPhotoForm form</h1>
	<?= $form->field($photo, 'path_fullsize')->textInput(['disabled' => true]) ?>
	<?= $form->field($photo, 'id')->textInput([ 'disabled' => true]) ?>

	</div>
</div>
<div class="form-group">
<?= Html::submitButton('Yes' , ['value'=>'yes','class' => 'btn btn-success','name'=>'action']) ?>
<?= Html::submitButton('No' , ['value'=>'no','class' => 'btn btn-success','name'=>'action']) ?>
</div>
<?php ActiveForm::end(); ?>
<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
