<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
   
?>
<h1>product/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
    <?php 
		echo Html::a('Home', ['site/index']);
		
		foreach($products as $p){
			echo Html::a($p->name, ['product/view','id' => $p->id],['class' => 'btn btn-info']);
		}
		
		echo $tmp;
	
	?>
</p>
