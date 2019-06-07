<?php

namespace app\controllers;
use yii\helpers\VarDumper;

use app\models\Customer;
use yii\base;
use yii\db\Query;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\CustomerSearch;

class CustomerController extends \yii\web\Controller
{
    public function actionGrid()
	{
		$query = Customer::find();
		$searchModel = new \app\models\CustomerSearch();
//		Yii::info(VarDumper::dumpAsString($_GET));
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		if(isset($_GET['CustomerSearch'])){
			$dataProvider = $searchModel->search($_GET['CustomerSearch']);
		}
		
		return $this->render('grid', [ 'dataProvider' => $dataProvider,'table_name'=>Customer::tableName(),'searchModel'=>$searchModel ]);
	}

    public function actionIndex()
    {
        return $this->render('index');
    }
	public function actionDelete($id){
		$item = Customer::findOne($id);
		if($item == NULL){
			throw new \yii\web\HttpException(404,
          "$id photo not found");
		}
		if (Yii::$app->request->post()){
//			$action = Yii::$app->request->post()['action'];
//			Yii::info(VarDumper::dumpAsString(Yii::$app->request->post()));
//			if($action =='yes'){	
				$item->delete();			
//			}
			return $this->redirect(['grid']);					
		}
		/* return $this->render('delete', [
			'photo'=>$photo,
			'width'=>\Yii::$app->params['thumbnail.size'][0],
			'height'=>\Yii::$app->params['thumbnail.size'][1]
		]); */
		/* $model = new ProductPhoto();
		$attributes = $model->getAttributes();
		foreach(array_keys($attributes) as $key){
			echo "$key => ".$this->ansiFormat($photo[$key], Console::FG_YELLOW).".\n";
		}
		
//		Yii::info(VarDumper::dumpAsString($photo->getProduct()));
		$product = $photo->getProduct()->one();//active query to single row result

		$attributes = $product->attributes;
		if(count($attributes) != 0){
			echo "product name -----$photo->product->name\n";//from public method name
			foreach($attributes as $key=>$value){
				echo "$key => ".$this->ansiFormat($value, Console::FG_YELLOW).".\n";
			}	
		} */
	} 

}
