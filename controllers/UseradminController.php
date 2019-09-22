<?php

namespace app\controllers;
use yii\helpers\VarDumper; 
//use app\models\form\ProductForm;
//use app\models\Product;
use yii\base;
use yii\db\Query;
use Yii;
use app\models\SignupForm;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

class UseradminController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
    */
	public function beforeAction($action)
	{
//		Yii::info('hello beforeAction');
//		if (in_array($action->id, ['index'])) {
//			$this->enableCsrfValidation = false;
//		}
		return parent::beforeAction($action);
	}
    public function behaviors()
    {
//		Yii::info('============');
        return [
			/* access' => [
                'class' => AccessControl::className(),
                'only' => ['special-callback'],
                'rules' => [
                    [
                        'actions' => ['special-callback'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return date('d-m') === '31-10';
                        }
                    ],
                ],
            ], */
			/* [
				'class' => AccessControl::className(),
				'denyCallback' => function ($rule, $action) {
					throw new \Exception('У вас нет доступа к этой странице');
				}
			] */
            /* 'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'allow' => true,
						'actions' => ['login', 'signup', 'index'],
						'roles' => ['?'],
                    ],
					[
                        'actions' => ['about'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
							return false;
                            return date('d-m') === '31-10';
                        }
                    ],
					[ // last rules for deny
                        'actions' => ['contact'],
                        'allow' => false,
                        'roles' => ['*'], // all roles
                        'denyCallback' => function($rule, $action) {
                            //redirect
                            Yii::$app->session->setFlash('info', 'Redirect for login');
                            return $action->controller->redirect('signup');
                        },
                    ],				
                ],
            ], */
			'access' => [
                        'class' => \yii\filters\AccessControl::className(),
                        'only' => ['contact','about','update','view','index'],
                        'rules' => [
                            // allow authenticated users
                            [
                                'allow' => true,
								'actions' => ['contact','about','login'],
                                'roles' => ['@'],
								
                            ],
							[
								'allow' => true,
								'actions' => ['index'],
//								'roles' => ['admin'],
							],
							/* [
                                'allow' => true,
								'actions' => ['about'],
                                'roles' => ['?'],
								
                            ], */
							/* [
                                'allow' => true,
								'actions' => ['about'],                         
								'matchCallback' => function ($rule, $action) {//$rule => actions['about'];
									return date('d-m') === '31-10';
								}
								
                            ], */
                            // everything else is denied
                        ],
						
            ],  
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
			'static' => [
				'class' => 'yii\web\ViewAction',
				'viewPrefix' => 'static'
			],// /basic/web/index.php?r=site/static&view=contact
			'page' => [
				'class' => 'yii\web\ViewAction',
//				'viewPrefix' => 'static'
			],// /basic/web/index.php?r=site/static&view=contact

		];
    }

	public function actionIndex()
    {
		$users = User::find()->all();
		Yii::info(VarDumper::dumpAsString(\Yii::getAlias('@editor_lang_dir')));

		/* if (!\Yii::$app->user->can('view')) {
			throw new ForbiddenHttpException('Access denied');
		} */
		$user_id = Yii::$app->user->getId();
		if($user_id){
			$roles =[];
			$userAssigned = Yii::$app->authManager->getAssignments($user_id);
			foreach($userAssigned as $userAssign){
				$roles[] = $userAssign->roleName;
			}
			if(in_array('admin',$roles)){
				return $this->render('index',['userList'=>$users]);	
			}
			
		}
		throw new ForbiddenHttpException('Access denied');        
    }
	
	public function actionCreate()
    {
        $model = new SignupForm();
		$errors = [];
//		Yii::error('actionCreate---------');
		if ($model->load(Yii::$app->request->post()) ) {
			$model->validate();
			if ($model->hasErrors()) {
			// validation fails
				Yii::info(VarDumper::dumpAsString($model->errors)); 
				$model->addErrors($model->errors);
//				return $this->render('create',['model'=>$model,'roles'=>$roles,'selection'=>$selection]);
			} else {
				// validation succeeds
				if ($user = $model->signup()) {
//					
	//				if (Yii::$app->getUser()->login($user)) {				   
						$auth = Yii::$app->authManager;
//						Yii::info(VarDumper::dumpAsString(Yii::$app->request->post()['roles'])); 
						if(isset(Yii::$app->request->post()['roles'])){
							foreach(Yii::$app->request->post()['roles'] as $roleName){
								$role = $auth->getRole($roleName); // 
								$auth->assign($role, $user->id);
		//						$auth = Yii::$app->authManager;
		//						$login = $auth->getRole('guest'); // 
		//						$auth->assign($login, $id);
							}
						}						
						return $this->goHome();
	//				}
				}				
			}            
        }	
		$userRoles = Yii::$app->authmanager->getRoles();
		$roles = [];
//		$roles2 = Yii::$app->db->createCommand('select * from auth_item')->queryAll();
		$selection = [];
		
		foreach($userRoles as $key=>$value){
			$roles[$key] = $value->name;
		}
		
		/* $authRoles = Yii::$app->authManager->getRolesByUser(1);		
		foreach($authRoles as $role){
				$selection[] = $role->name;
		} */
//		
        return $this->render('create',['model'=>$model,'roles'=>$roles,'selection'=>$selection]);
    }
    public function actionDelete($id)
    {
		$user = User::findOne($id);
		if($user === NULL) throw new ForbiddenHttpException('Model not found'); 
		$user->delete();			
		
		return $this->redirect(['useradmin/index']);		
    }

    public function actionDetail()
    {
        return $this->render('detail');
    }

    public function actionEdit($id)
    {
        $model = new SignupForm();
		$user = User::findOne($id);
		if($user === NULL) throw new ForbiddenHttpException('Model not found'); 
//		Yii::info(VarDumper::export($user->attributes));		
//		$model->attributes = $user;
		$model->username = $user->username;
		$model->email = $user->email;
		$model->username = $user->username;
		$model->status = $user->status;
		if ($model->load(Yii::$app->request->post())) {
			$model->validate();
			if ($model->hasErrors()) {
			// validation fails
				Yii::info(VarDumper::dumpAsString($model->errors)); 
				$model->addErrors($model->errors);
			} else {
				// validation succeeds
				/* if ($user = $model->signup()) {			   
						$auth = Yii::$app->authManager;
						if(isset(Yii::$app->request->post()['roles'])){
							foreach(Yii::$app->request->post()['roles'] as $roleName){
								$role = $auth->getRole($roleName); // 
								$auth->assign($role, $user->id);
		//						$auth = Yii::$app->authManager;
		//						$login = $auth->getRole('guest'); // 
		//						$auth->assign($login, $id);
							}
						}						
						return $this->goHome();
				}			 */	
			}            
        }	
		$userRoles = Yii::$app->authmanager->getRoles();
		$roles = [];
//		$roles2 = Yii::$app->db->createCommand('select * from auth_item')->queryAll();
		$selection = [];
		
		foreach($userRoles as $key=>$value){
			$roles[$key] = $value->name;
		}
		
		/* $authRoles = Yii::$app->authManager->getRolesByUser(1);		
		foreach($authRoles as $role){
				$selection[] = $role->name;
		} */	
        return $this->render('create',['model'=>$model,'roles'=>$roles,'selection'=>$selection]);
    }

    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionSinup()
    {
        return $this->render('sinup');
    }

}
