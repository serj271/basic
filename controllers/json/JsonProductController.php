<?php

namespace app\controllers\json;
use yii\db\Query;
use app\models\Product;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use Yii;
use yii\helpers\VarDumper; 
use yii\filters\Cors;

class JsonProductController extends \yii\web\Controller
{
//	public $modelClass = 'modules\models\Product';
	
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
			'only' => ['create', 'update', 'delete','index','view'],
			'rules' => [
				[
					'actions' => ['index','view'],
					'allow' => true,
					'roles' => ['?'],
				],
				[
                    'allow' => false,
					'verbs' => ['POST','GET','PUT','DELETE']
                ],
				[
					'actions' => ['create', 'update', 'delete'],
					'allow' => true,
					'roles' => ['@'],
				],		 	
			],
		]; */
        return $behaviors;
    }
	public function beforeAction($action)
	{            
//		if ($action->id == 'my-method') {
			$this->enableCsrfValidation = false;
//		}

		return parent::beforeAction($action);
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
        $data = Product::find()->all();
		
        return $data;
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

    public function actionView($id = NUll)
    {
		if (Yii::$app->request->isAjax){
			if (Yii::$app->request->post() && isset(Yii::$app->request->post()['id'])){
				/* Yii::info(VarDumper::dumpAsString(Yii::$app->request->post())); 
				Yii::info(VarDumper::dumpAsString($_POST)); // []
				Yii::info(VarDumper::dumpAsString(Yii::$app->request->csrfParam));
				Yii::info(VarDumper::dumpAsString(Yii::$app->request->csrfToken)); */
			
//				$id = \yii\helpers\Json::decode(Yii::$app->request->post());
				$data = Product::findOne(Yii::$app->request->post()['id']);
//				Yii::info(VarDumper::dumpAsString($data->photos));
				return $data;
			}
		}			
		
        $data = Product::findOne($id);
        return $data;
    }

}
