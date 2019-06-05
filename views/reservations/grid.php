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
		'filterSelector'=>'body',//\yii\grid\GridView::FILTER_POS_FOOTER
		'columns' => [
			'id',
			'room_id',
			'customer_id',			
			[
				'header' => 'Customer',
				'attribute' => 'customer.nameAndSurname'
			],
			'price_per_day',
			'date_from',
			'date_to',
			'reservation_date',
			['content'=>function ($model, $key, $index, $column) {
				return Html::button('&lt;i class="glyphicon glyphicon-plus">&lt;/i>', ['type'=>'button', 'title'=>'Add Book', 'class'=>'btn btn-success',
					'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
					Html::a('&lt;i class="glyphicon glyphicon-repeat">&lt;/i>', ['grid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default', 
					'title'=>'Reset Grid']);
				}			
			],
			
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