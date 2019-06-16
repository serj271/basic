<?php

namespace app\controllers;
use yii\helpers\VarDumper;

use app\models\Reservation;
use app\models\Customer;
use yii\base;
use yii\db\Query;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\ReservationForm;
use yii\helpers\ArrayHelper;

class ReservationsController extends \yii\web\Controller
{
    public function actionGrid()
    {
        $query = Reservation::find();
//		$searchModel = new \app\models\Reservation();
		$searchModel = new \app\models\ReservationSearch();
//		Yii::info(VarDumper::dumpAsString($_GET));
//		Yii::info(VarDumper::dumpAsString($searchModel));
		if(isset($_GET['ReservationSearch']))
		{
//			Yii::info(VarDumper::dumpAsString(\Yii::$app->request->get()));
			
			$searchModel->load( \Yii::$app->request->get() );
//			Yii::info(VarDumper::dumpAsString($searchModel));
			/* $query->andFilterWhere([
			'customer_id' => isset($_GET['Reservation']['customer_id'])?
			$_GET['Reservation']['customer_id']:null,
			]); */
			$query->joinWith(['customer']);
			/* $query->andFilterWhere(
				['LIKE', 'customer.surname', $searchModel->nameAndSurname]
			); */
			$query->andWhere('name LIKE "%' . $searchModel->nameAndSurname . '%" ' .
			'OR surname LIKE "%' . $searchModel->nameAndSurname . '%"'
			);
		}
		if(isset($_GET['Reservation'])){
			$searchModel = new \app\models\Reservation();
//			Yii::info(VarDumper::dumpAsString('---------Reservation---'));
			$searchModel->load( \Yii::$app->request->get() );
			$query->andFilterWhere([
//				'id' => $searchModel->id,
				'customer_id' => $searchModel->customer_id,
//				'room_id' => $searchModel->room_id,
//				'price_per_day' => $searchModel->price_per_day,
			]);
			
//			Yii::info(VarDumper::dumpAsString($searchModel->count()));
		}
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		return $this->render('grid', [ 'dataProvider' => $dataProvider,'searchModel'=>$searchModel]);
    }
	public function actionDetail()
	{
		$showDetail = false;
		$model = new Reservation();
		if(isset($_POST['Reservation']))
		{
			$model->load( Yii::$app->request->post() );
			if(isset($_POST['Reservation']['id'])&&($_POST['Reservation']['id']!=null))
			{
				$model = Reservation::findOne($_POST['Reservation']['id']);
				$showDetail = true;
			}
		}
		return $this->render('detail', [ 'model' => $model,
			'showDetail' => $showDetail ]);
	}
	public function actionAjaxDropDownListByCustomerid($customer_id)
	{
		$output = '';
		$items = Reservation::findAll(['customer_id' => $customer_id]);
		foreach($items as $item)
		{
			$content = sprintf('reservation #%s at %s', $item->id, date('Y-m-d H:i:s',
				strtotime($item->reservation_date)));
			$output .= \yii\helpers\Html::tag('option', $content, ['value' => $item->id]);
		}
		return $output;
	}
	public function actionCreate()
    {
		$reservation = new ReservationForm();
		if(Yii::$app->request->post())
		{
//			Yii::info(VarDumper::dumpAsString(Yii::$app->request->post()));
			$reservation->load( Yii::$app->request->post() );
			$reservation->date_from = Yii::$app->formatter->asDate(
				date_create_from_format('d/m/Y', $reservation->date_from), 'php:Y-m-d' );
			$reservation->date_to = Yii::$app->formatter->asDate(
				date_create_from_format('d/m/Y', $reservation->date_to), 'php:Y-m-d' );
//				Yii::info(VarDumper::dumpAsString($_POST['Reservation']));
//				Yii::info(VarDumper::dumpAsString($reservation));
			$reservationUpdated = $reservation->save();
			return Yii::$app->response->redirect(['customer/grid']);
		}
		$items = Customer::find()
			->indexBy('id')
			->asArray()
			->all();
//		Yii::info(VarDumper::dumpAsString(ArrayHelper::map($items, 'id', 'name')));
        return $this->render('create',['model'=>$reservation,'items'=>ArrayHelper::map($items, 'id', 'name')]);
    }

    public function actionIndex()
    {
		
        return $this->render('index');
    }

}
