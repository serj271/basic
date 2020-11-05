<?php

namespace app\controllers\json;
use Yii;
use yii\db\Query;
use app\models\User;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

class UserController extends \yii\web\Controller
{
	public $modelClass = 'modules\models\User';

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent :: beforeAction($action);
    }

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
		/*$behaviors['authenticator'] = [
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
		];*/
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
      return 'ok';
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

    public function actionGetOne()
    {
        /** @var int $user */
        $id =1;
        ;
  //      if (Yii::$app->request->isAjax){
            $request = Yii::$app->request;
            if ($request->isPost){
                $id = $request->getBodyParam('id');
    //            echo "$id\n";
                $user = User::findOne($id);
                return $user;

   //         } else {
   //             return ['message'=>'hello post ajax'];
            }
    //    }
        return ['message'=>'hello get ajax'];

    }
    public function actionGetAll()
    {
        /** @var array $users */
        $users = User::find()->all();
        return $users;
    }

}
//curl -i -H 'Content-Type: application/json' http://192.168.1.1/basic/web/json/user/get-all
//echo Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []);

/*$.ajax({
    url: urlAjax,
    type: 'POST',
    data: {"id": 1, "_csrf": yii.getCsrfToken()},
    dataType: 'json',
}).done(function (response) {
    console.log(response);
});*/

