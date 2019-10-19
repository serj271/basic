<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

use yii\bootstrap\Modal;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/product.js', [
	'position' => \yii\web\View::POS_END,
	'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
/* @var $this yii\web\View */
$this->params['breadcrumbs'] = $breadcrumbs;
?>
<h1>product-admin/view</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<?php
echo $product['id'].'--'.$product['name'];
//		if($product){
///			echo $product->id.'--'.$product->name;
//		}
		foreach($photos as $photo){
			echo $photo['path_fullsize'];
			?>
<!--			<img src="<?php echo Yii::getAlias('@web').'/product/'.$photo['path_fullsize'] ?>" 
				width="<?=Yii::$app->params['thumbnail.size'][0]?>"
				height="<?Yii::$app->params['thumbnail.size'][1]?>"
				>
-->
				<a href="#"  onclick="$('#modal').modal('show');"value="<?=$photo->id?>">
					<?= Html::img(Yii::getAlias('@web').'/product/'.$photo['path_fullsize'], 
						[
							'alt' => $photo->id,
//							'width'=>Yii::$app->params['thumbnail.size'][0],
							'height'=>Yii::$app->params['thumbnail.size'][1]
						]
					)?>
				</a>
			<?php
		}


?>