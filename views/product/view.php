<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
?>
<h1>product/view</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>
	<a href="<?php echo Yii::$app->urlManager->createUrl(['news/item-detail' , 'id'=> $product->id]) ?>"><?php echo $product->name ?></a>
	<?php 
		echo Html::a('Product', ['product/index']);
		
		if($product){
			echo $product->id.'--'.$product->name;
		}
		
	
	?>
	
	
	
</p>
