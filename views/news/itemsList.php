<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'My items list';

?>
<?php echo $this->context->renderPartial('_copyright'); ?>
<table>
<tr>
<th>Title</th>
<th>Date</th>
</tr>
<?php foreach($newsList as $item) { ?>
<tr>
<th><a href="<?php echo Yii::$app->urlManager->createUrl(['news/item-detail' ,
'title' => $item['title']]) ?>"><?php echo $item['title'] ?></a></th>
<th><?php echo Yii::$app->formatter->asDatetime($item['date'], "php:d/m/Y"); ?></th>
</tr>
<?php } ?>
</table>
<?php if($year != null) { ?>
<b>List for year <?php echo $year ?></b>
<?php } ?>
<?php if($category != null) { ?>
	<b>List for category <?php echo $category ?></b>
<?php } ?>
<br /><br />
<table border="1">
	<tr>
		<th>Date</th>
		<th>Category</th>
		<th>Title</th>
	</tr>
	<?php foreach($filteredData as $fd) { ?>
	<tr>
		<td><?php echo $fd['date'] ?></td>
		<td><?php echo $fd['category'] ?></td>
		<td><?php echo $fd['title'] ?></td>
	</tr>
	<?php } ?>
</table>
<?= Html::a( 'List items by year ',['news/items-list','year'=>'2015']) ?>
<?= Html::a('Profile', ['user/view', 'id' =>'0'], ['class' => 'profile-link']) ?>
<p>
<?php
$url = Url::toRoute(['page/view', 'id' => 23]);
echo Html::a('page 23', ['page/view', 'id' => 23]); ?>
</p>



