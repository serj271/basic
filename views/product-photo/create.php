<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
?>
<?php if($modelSaved) { ?>
<div class="alert alert-success">
Model ready to be saved!
</div>
<?php } ?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
<div class="col-lg-12">
<h1>ProductPhotoForm form</h1>

<?= $form->field($model_upload, 'imageFile')->fileInput() ?>

</div>
</div>
<div class="form-group">
<?= Html::submitButton('Create' , ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
<h1>product-photo/create</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
