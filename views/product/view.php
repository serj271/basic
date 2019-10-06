<?php
use yii\helpers\Html;

use yii\bootstrap\Modal;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/product.js', [
	'position' => \yii\web\View::POS_END,
	'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
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
	/* 	Modal::begin([
    'header' => '<h2>Hello world</h2>',
    'toggleButton' => ['label' => 'click me'],
    'footer' => 'Низ окна',
	]);
	echo 'Say hello...';
 
	Modal::end(); */
	yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    'closeButton' => [
        'id'=>'close-button',
        'class'=>'close',
        'data-dismiss' =>'modal',
        ],
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => [
        'backdrop' => false, 'keyboard' => true
        ]
	]);
	echo "<div id='modalContent'><div style='text-align:center'>" . Html::img('@web/product/1.png') . "</div></div>";
	yii\bootstrap\Modal::end();

	
	?>
	

	
</p>
