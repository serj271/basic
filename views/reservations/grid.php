<?php
/* @var $this yii\web\View */
//use yii\grid\GridView;
use app\components\GridViewReservation;
use yii\helpers\Html;
?>
<h1>reservation/grid</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<?php 
	if(count($dataProvider->getModels()) > 0){
		echo "ok models";
	}
?>

<?= GridViewReservation::widget([
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
				'attribute'=>'nameAndSurname',
				'value' => 'customer.nameAndSurname'
			],
			[
				'attribute'=>'price_per_day',
				'value'=>'price_per_day'
			],
//			'price_per_day',
			'date_from',
			'date_to',
			'reservation_date',
			['content'=>function ($model, $key, $index, $column) {
				return Html::button('<span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>'.'test', ['type'=>'button', 'title'=>'Add Book', 'class'=>'btn btn-success',
					'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
					Html::a('&lt;i class="glyphicon glyphicon-repeat">&lt;/i>', ['grid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default', 
					'title'=>'Reset Grid']);
				}			
			],
			[
				'class'=>'yii\grid\ActionColumn',
				'template'=>'{update}{delete}'
			],
			[
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete} {link}',
            'buttons' => [
                'update' => function ($url,$model) {
                    return Html::a(
                    '<span class="glyphicon glyphicon-screenshot"></span>', 
                    $url);
                },
                'link' => function ($url,$model,$key) {
                    return Html::a('Действие', $url);
                },
            ],
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