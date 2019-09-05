<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
?>
<h1>product/view</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>
	<?php 
		echo Html::a('Product', ['product/index']);
		echo $product['id'].'--'.$product['name'];
//		if($product){
///			echo $product->id.'--'.$product->name;
//		}
		foreach($photos as $photo){
			echo $photo['path_fullsize'];
			?>
			<img src="<?php echo Yii::getAlias('@web').$photo['path_fullsize'] ?>" width=200 height=100>
			<?php
		}
	
	?>
	

	
</p>
