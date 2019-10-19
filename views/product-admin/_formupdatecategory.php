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
		<?= $form->field($productUpdatecategoryForm->product, 'uri')->textInput() ?>
        <?= $form->field($productUpdatecategoryForm->product, 'description')->textInput() ?>
        <?= $form->field($productUpdatecategoryForm->product, 'visible')->textInput() ?>
        
        <?= $form->field($productUpdatecategoryForm->product, 'primary_photo_id')->textInput() ?> 
        <?= $form->field($productUpdatecategoryForm->product, 'id')->textInput() ?>
    </fieldset>

    <fieldset>
        <legend>Category</legend>
		
		<?= $form->field($productUpdatecategoryForm->productCategories, 'id')->dropDownList($categories, ['options' =>[ $selected => ['Selected' => true]]]);?>
    </fieldset>

    <?= Html::submitButton('Save'); ?>
    <?php ActiveForm::end(); ?>

</div><!-- product-form -->
