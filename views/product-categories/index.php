<?php
/* @var $this yii\web\View */
?>
<h1>product-categories/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<p>
	<?php foreach($categories as $category) { ?>
	<dl>
		<dt><?php echo $category['id'] ?></dt>
		<dd>
			<?=$category['name'] ?> 
			<?=$category['description'] ?>
			
		</dd>
	
	</dl>
	<?php } ?> 


</p> 