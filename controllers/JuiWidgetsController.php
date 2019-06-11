<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Reservation;
use yii\helpers\VarDumper;
use yii\web\ForbiddenHttpException;

class JuiWidgetsController extends \yii\web\Controller
{
    public function actionDatePicker()
    {
		$reservationUpdated = false;
		$reservation = Reservation::find()->one();
		if($reservation == NULL) throw new ForbiddenHttpException('Model not found'); 
		if(isset($_POST['Reservation']))
		{
			$reservation->load( Yii::$app->request->post() );
			$reservation->date_from = Yii::$app->formatter->asDate(
				date_create_from_format('d/m/Y', $reservation->date_from), 'php:Y-m-d' );
			$reservation->date_to = Yii::$app->formatter->asDate(
				date_create_from_format('d/m/Y', $reservation->date_to), 'php:Y-m-d' );
//				Yii::info(VarDumper::dumpAsString($_POST['Reservation']));
//				Yii::info(VarDumper::dumpAsString($reservation));
				$reservationUpdated = $reservation->save();
		}
		return $this->render('datePicker', ['reservation' => $reservation,
		'reservationUpdated' => $reservationUpdated]);
//        return $this->render('date-picker');
    }

}
