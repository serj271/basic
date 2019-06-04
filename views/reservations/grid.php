<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;
?>
<h1>reservation/grid</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'caption'=>'reservation',
		'filterModel' => $searchModel,
		'columns' => [
			'id',
			'room_id',
			'customer_id',
			'price_per_day',
			'date_from',
			'date_to',
			'reservation_date'
			
		/* 	'name', */
			/* [
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
						return Html::a('Reservations', ['reservations/grid',
							'Reservation[customer_id]' => $model->id]);
				}
			], */
			
		],
	]) 
?>