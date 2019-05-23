<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
   
?>
<h1>product/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>
	
    <?php 
		echo Html::a('Home', ['site/index']);
		echo \yii\widgets\DetailView::widget(
		[
			'model' => $model,
			'attributes' => [
				['attribute' => 'name'],
				['attribute'=>'id'],
				['attribute'=>'primary_photo_id'],
				['attribute'=>'created_at', 'value' => function($model){return 'create - '.$model->created_at;}],
				['label'=>'description on','attribute'=>'description']
			]
		]);
		
		foreach($products as $p){
			echo Html::a($p->name, ['product/view','id' => $p->id],['class' => 'btn btn-info']);
		}
		
		echo $tmp;
	
	?>
</p>
