<?php

namespace app\controllers\json;
use Yii;
use yii\db\Query;
use app\models\User;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

class JsonUserController extends \yii\web\Controller
{
	public $modelClass = 'modules\models\User';
	
	public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter' ] = [
              'class' => \yii\filters\Cors::className(),
        ];
        $behaviors['contentNegotiator'] = [
			'class' => \yii\filters\ContentNegotiator::className(),
			'formats' => [
				'application/json' => \yii\web\Response::FORMAT_JSON,
			],
		];
		/* $behaviors['access'] = [
			'class' => \yii\filters\AccessControl::className(),
			'only' => ['create', 'update', 'delete'],
			'rules' => [
				[
					'actions' => ['create', 'update', 'delete'],
					'allow' => true,
					'roles' => ['@'],
				],
			],
		]; */
		$behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className()
        ];
		$behaviors['access'] = [
			'class' => \yii\filters\AccessControl::className(),
			'only' => ['create', 'update', 'delete'],
			'rules' => [
				[
					'actions' => ['create', 'update', 'delete'],
					'allow' => true,
					'roles' => ['@'],
				],
			],
		];
        return $behaviors;
    }
	
    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionEdit()
    {
        return $this->render('edit');
    }

    public function actionIndex()
    {
		$data = User::find()->all();
		
        return $data;
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

    public function actionView($id)
    {
		$data = User::findOne($id);
        return $data;
    }

}
