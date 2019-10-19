<?php
/* @var $this yii\web\View */
$this->params['breadcrumbs'] = $breadcrumbs;
$this->params['breadcrumbs'][] = $category['name'];
?>
<h1>product-categories/view</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<dl>
	<dt><?php echo $category['id'] ?></dt>
	<dd>
		<?=$category['name'] ?> 
		<?=$category['description'] ?>
		
	</dd>	
</dl>
<?php if($children) { ?>
	<h3>categories</h3>
<?php } ?> 
<?php foreach($children as $item) { ?>
	<dl>
		<dt><?php echo $item['id'] ?></dt>
		<dd>
			<?=$item['name'] ?> 
			<a href="<?php echo Yii::$app->urlManager->createUrl(['categories' ,
			'url' => $item['uri']]) ?>"><?php echo $item['name'] ?></a>
			
		</dd>
	
	</dl>
<?php } ?> 
<h3>product</h3>
<?php foreach($products as $product) { ?>
	<dl>
		<dt><?php echo $product['id'] ?></dt>
		<dd>
			
			<a href="<?php echo Yii::$app->urlManager->createUrl(['product' ,
			'url' => $product['uri']]) ?>"><?php echo $product['name'] ?></a>
			
		</dd>
	
	</dl>
<?php } ?> 
 
