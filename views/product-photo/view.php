<?php
/* @var $this yii\web\View */
use yii\helpers\Html;


?>
<h1>product-photo/view</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
	<img src="<?php echo Yii::getAlias('@web').'/'.$photo['path_thumbnail'] ?>" width=<?=$width?> height=<?=$height?>> 
	
</p>
