<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

echo Html::beginform(['/customers'], 'get');
echo Html::label ('Phone numbeг to search:' , 'phone_number') ;
echo Html::textInput('phone_number');
echo Html::submitButton('Search');
echo Html::endForm();

?>
<h1>product-photo/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
	<?php foreach($photos as $photo) { ?>
	<dl>
		<dt><?php echo $photo['product_id'] ?></dt>
		<dd>
			<img src="<?php echo Yii::getAlias('@web').'/'.$photo['path_thumbnail'] ?>" width=<?=$width?> height=<?=$height?>> 
			<?= Html::a( "Edit ",['product-photo/edit','id'=>$photo['id']]) ?> 
		</dd>
	
	</dl>
	<?php } ?> 
</p>
