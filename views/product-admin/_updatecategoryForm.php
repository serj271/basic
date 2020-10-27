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





    <fieldset>
        <legend>Category</legend>
		
        <?= /** @var object $productUpdatecategoryForm */
        $form->field($productUpdatecategoryForm->productCategories, 'category')
            ->dropDownList($categories, ['options' =>[ $selected => ['Selected' => true]]]);?>
    </fieldset>

    <?= Html::submitButton('Save'); ?>
    <?php ActiveForm::end(); ?>

</div><!-- product-form -->
