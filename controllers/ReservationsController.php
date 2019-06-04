<?php

namespace app\controllers;
use yii\helpers\VarDumper;

use app\models\Reservation;
use yii\base;
use yii\db\Query;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

class ReservationsController extends \yii\web\Controller
{
    public function actionGrid()
    {
        $query = Reservation::find();
		$searchModel = new \app\models\Reservation();
//		Yii::info(VarDumper::dumpAsString($_GET));
		if(isset($_GET['Reservation']))
		{
//			Yii::info(VarDumper::dumpAsString($_GET['Reservation']));
			$searchModel->load( \Yii::$app->request->get() );
			$query->andFilterWhere([
				'id' => $searchModel->id,
				'customer_id' => $searchModel->customer_id,
				'room_id' => $searchModel->room_id,
				'price_per_day' => $searchModel->price_per_day,
			]);
			/* $query->andFilterWhere([
			'customer_id' => isset($_GET['Reservation']['customer_id'])?
			$_GET['Reservation']['customer_id']:null,
			]); */
		}
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		return $this->render('grid', [ 'dataProvider' => $dataProvider,'searchModel'=>$searchModel]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
