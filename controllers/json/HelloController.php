<?php

namespace app\controllers\json;
use app\models\Customer;
use yii\base;
use yii\db\Query;
use Yii;

class HelloController extends \yii\web\Controller
{
    public function actionInfo()
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return [
			’message’ => ’hello world’,
			’code’ => 100,
		];
	}

}
