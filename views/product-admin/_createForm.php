<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductForm */
/* @var $form ActiveForm */
?>
<div class="product-update-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $productUpdatecategoryForm->errorSummary($form); ?>

    <fieldset>
        <legend>Product</legend>
        <?= $form->field($productUpdatecategoryForm->product, 'name')->textInput() ?>
		<?= $form->field($productUpdatecategoryForm->product, 'uri') ?>
        <?= $form->field($productUpdatecategoryForm->product, 'description') ?>
        <?= $form->field($productUpdatecategoryForm->product, 'visible') ?>
        
        <?= $form->field($productUpdatecategoryForm->product, 'primary_photo_id') ?>
        <?= $form->field($productUpdatecategoryForm->product, 'id')->textInput(['value'=>$productUpdatecategoryForm->product->id,'readonly'=> true])?> 
    </fieldset>

    <fieldset>
        <legend>Category</legend>
		
		<?= $form->field($productUpdatecategoryForm->productCategories, 'id')->dropDownList($categories);?>
    </fieldset>

    <?= Html::submitButton('Save'); ?>
    <?php ActiveForm::end(); ?>

</div><!-- product-form -->
