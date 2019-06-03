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

class ReservationController extends \yii\web\Controller
{
    public function actionGrid()
    {
        $query = Reservation::find();
		if(isset($_GET['Reservation']))
		{
			$query->andFilterWhere([
			'customer_id' => isset($_GET['Reservation']['customer_id'])?
			$_GET['Reservation']['customer_id']:null,
			]);
		}
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		return $this->render('grid', [ 'dataProvider' => $dataProvider ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
