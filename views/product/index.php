<?php
/* @var $this yii\web\View */
$this->params['breadcrumbs'][] = 'Products';
?>
<h1>product/index</h1>

<p>
    You may change the content of this page by modifying rr
    the file <code><?= __FILE__; ?></code>.
</p>

<p>
	<?php foreach($products as $product) { ?>
	<dl>
		<dt><?php echo $product['id'] ?></dt>
		<dd>
			<?=$product['name'] ?> 
			<?=$product['description'] ?>
			<?=$product['created_at'] ?>
			<?=$product['updated_at'] ?>
		</dd>
	
	</dl>
	<?php } ?> 


</p>

