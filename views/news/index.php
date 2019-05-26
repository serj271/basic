<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<?php echo $this->context->renderPartial('_menu'); ?>
<div class="site-index">

<h1>News</h1>
<?= Html::a('Click Me', ['news/items-list', 'year' => 2015]) ?>
</div>
