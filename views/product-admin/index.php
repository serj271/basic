
<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html; 
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use app\assets\ProductAdminAsset;
use Yii;

ProductAdminAsset::register($this);
$uri = Yii::$app->urlManager->createUrl(['json','controller'=>'json-product', 'action'=>'view']);
		$url = 'http://192.168.1.1'.$uri;
?>
<script>
    function myFunction()
    {
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/json/json-product/view' ?>',
           type: 'post',
           data: {id: $("#searchname").val()},
           success: function (data) {
              console.log(data);

           }

      });
    }
</script>
<h1>product-admin/index</h1>
<input type="text" value ="" name="searchname", id="searchname">
<button onclick="myFunction()">Search</button>
<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>


<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'caption'=>$table_name,
		'columns'=>ArrayHelper::merge(array_keys($attributes),[[
                'class' => \yii\grid\SerialColumn::class,
            ],
			[
			'attribute' => 'category',
		        'value' => function($model) {
					if(empty($model->category)){
						return '';						
					} else {
						return $model->category[0]->name;
					}
			    }
			],			
			['class' => 'yii\grid\ActionColumn',
			'template' => '{view} {edit} {updatecategory} {delete}',
			'buttons' => [
				'edit' => function ($url, $model, $key){
//					 return $model->status === 'editable';
					return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'lead-update'),
					]);
				},
				'updatecategory' => function ($url, $model, $key){
//					 return $model->status === 'editable';
					return Html::a('<span class="glyphicon glyphicon glyphicon-wrench"></span>', $url, [
                            'title' => Yii::t('app', 'update category'),
					]);
				},
				'delete' => function($url, $model, $key){
	//				$url = $this->createUrl('view', array('id' => 42)); // page/view id=42
//					$url = \yii\helpers\Url::toRoute(['delete','id' => 22]);
					return Html::a('<span class="glyphicon glyphicon-trash"></span>', 
						$url, [
						'class' => '',
						'data' => [
							'confirm' => 'Are you absolutely sure ?',
							'method' => 'post',
							'params' => ['id' => $model->id]
						],
					]);
				}
			],
			'urlCreator' => function ($action, $model, $key, $index) {				
				return Yii::$app->urlManager->createUrl(['product-admin', 'action'=>$action, 'id' => $model->id]);
			},
			'header' => 'Actions',],
			
			])
		
//		'columns' => [
//			'id',
		/* 	'name', */
			/* [
				'header' => 'Name',
				'content'=>function ($model, $key, $index, $column) {
					return ucfirst($model->name);
				}
			], */
		/* 	'name:text:Name',
			'uri', */
//			'nameAndSurname',
			
//			'phone_number',
			/* [
				'header' => 'Reservations',
				'content' => function ($model, $key, $index, $column) {
						$title = sprintf('Reservations (%d)', $model->reservationsCount);
						return Html::a($title, ['reservations/grid', 'Reservation[customer_id]'=> $model->id]);
				}
			], */
			/* [
			'class' => 'yii\grid\ActionColumn',
			'template' => '{delete}',
			'header' => 'Actions',
			], */
//		],
	]) 
?>