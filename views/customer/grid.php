<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;
?>
<h1>customer/grid</h1>
<h2>Customers</h2>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'caption'=>$table_name,
		'columns' => [
			'id',
		/* 	'name', */
			[
				'header' => 'Name',
				'content'=>function ($model, $key, $index, $column) {
					return ucfirst($model->name);
				}
			],
			'surname',
			
			'phone_number',
			[
				'header' => 'Reservations',
				'content' => function ($model, $key, $index, $column) {
						$title = sprintf('Reservations (%d)', $model->reservationsCount);
						return Html::a($title, ['reservations/grid', 'Reservation[customer_id]'=> $model->id]);
				}
			],
			[
			'class' => 'yii\grid\ActionColumn',
			'template' => '{delete}',
			'header' => 'Actions',
			],
		],
	]) 
?>