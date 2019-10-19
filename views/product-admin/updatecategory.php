<?php
/* @var $this yii\web\View */
?>
<h1>product-admin/editcategory</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<?php echo $this->context->renderPartial('_formupdatecategory',[
	'productUpdatecategoryForm'=>$productUpdatecategoryForm,
	'categories' => $categories,
	'selected'=> $selected
	
]); ?>