<?php

namespace app\controllers\json;
use app\models\Customer;
use yii\base;
use yii\db\Query;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\helpers\VarDumper;
use yii\filters\Cors;
use Yii;

class HelloController extends \yii\web\Controller
{
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
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax){
            $request = Yii::$app->request;
            if ($request->isPost){
                /* Yii::info(VarDumper::dumpAsString(Yii::$app->request->post()));
                Yii::info(VarDumper::dumpAsString($_POST)); // []
                Yii::info(VarDumper::dumpAsString(Yii::$app->request->csrfParam));
                Yii::info(VarDumper::dumpAsString(Yii::$app->request->csrfToken)); */

//				$id = \yii\helpers\Json::decode(Yii::$app->request->post());
 //               $data = Product::findOne(Yii::$app->request->post()['id']);
//				Yii::info(VarDumper::dumpAsString($data->photos));
                return ['message'=>'hello post'];
            } else {
                return ['message'=>'hello get ajax'];
            }
        }

//        $data = Product::findOne($id);
  //      return $data;
        return ['message'=>'hello no ajax'];
    }
    public function actionInfo()
    {
        Yii::info('--------------info');
        Yii::info(VarDumper::dumpAsString(Yii::$app->getRequest()->getBodyParams()));
 //       $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $body = Yii::$app->getRequest()->getBodyParams();
//        Yii::info(VarDumper::dumpAsString(Yii::$app->getRequest()->getRawBody(), true));
//        Yii::info(VarDumper::dumpAsString($body));
        if (Yii::$app->request->isAjax){
            Yii::info('------ajax');
        }

        /*if ($body){
            return \Yii::createObject([
                'class' => 'yii\web\Response',
                'format' => \yii\web\Response::FORMAT_JSON,
                'data' => [
                    'message' => 'hello world',
                    'id' => $body['id'],

                ],
            ]);
        }*/
        if (Yii::$app->request->isAjax){
            if (Yii::$app->request->post() ){
                /* Yii::info(VarDumper::dumpAsString(Yii::$app->request->post()));
                Yii::info(VarDumper::dumpAsString($_POST)); // []
                Yii::info(VarDumper::dumpAsString(Yii::$app->request->csrfParam));
                Yii::info(VarDumper::dumpAsString(Yii::$app->request->csrfToken)); */

//				$id = \yii\helpers\Json::decode(Yii::$app->request->post());
                //               $data = Product::findOne(Yii::$app->request->post()['id']);
//				Yii::info(VarDumper::dumpAsString($data->photos));
              $id = Yii::$app->request->post()['id'];
                return \Yii::createObject([
                    'class' => 'yii\web\Response',
                    'format' => \yii\web\Response::FORMAT_JSON,
                    'data' => [
                        'message' => 'hello world',
                        'code' => 1030,
                        'id'=> $id
                    ],
                ]);
            }
        }
        return \Yii::createObject([
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_JSON,
            'data' => [
                'message' => 'hello world',
                'code' => 100
            ],
        ]);
    }

}
// curl -i -X GET / POST =H "Accept:application/json" http://192.168.1.1/basic/web/json/hello
//curl -i -H "accept: application/json" -H "X-Requested-With: XMLHttpRequest" -X GET set ajax get request
