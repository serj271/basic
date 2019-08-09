<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\SignupForm;
use yii\helpers\VarDumper;
use yii\web\ForbiddenHttpException;
use app\components\MyBehavior;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
    */
	public function beforeAction($action)
	{
//		Yii::info('hello beforeAction');
		if (in_array($action->id, ['index'])) {
			$this->enableCsrfValidation = false;
		}
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
                        'only' => ['contact','about','update','view'],
                        'rules' => [
                            // allow authenticated users
                            [
                                'allow' => true,
								'actions' => ['contact','about'],
                                'roles' => ['@'],
								
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		$identity = Yii::$app->user->identity;
		\app\modules\mymodule\MyAsset::register($this->view);
//		Yii::info('hello');
//		Yii::info(Yii::$app->params['adminEmail'],'------------------');
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {			
            return $this->goBack();
        }
//	Yii::info('-------------------login');
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
		/* if (Yii::$app->user->isGuest)
			throw new ForbiddenHttpException; */
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
//		$nameToDisplay = Yii::$app->request->get('nameToDisplay');
// Equivalent to
// $nameToDisplay = isset($_GET['nameToDisplay'])?$_GET['nameToDisplay']:null;
 //       return $this->render('about',[ 'nameToDisplay' => $nameToDisplay ]);
//		Yii::info(VarDumper::dump('----------------',\Yii::$app->user->can('admin')));
		if (!\Yii::$app->user->can('admin')) {//role admin require
			throw new ForbiddenHttpException('Access denied');
		}
		
		return $this->render('about');
    }
	
	public function actionSay($message = 'Hello')
	{
		return $this->render('say', ['message' => $message]);
	}
	public function actionEntry()
	{
		$model = new EntryForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate())
		{
		// valid data received in $model
		// do something meaningful here about $model ...
			return $this->render('entry-confirm', ['model' => $model]);
		} else {
		// either the page is initially displayed or there is some validation error
			return $this->render('entry', ['model' => $model]);
		}
	}
	public function actionSignup()
    {
        $model = new SignupForm();
//		Yii::info('model---------'); 
        if ($model->load(Yii::$app->request->post()) ) {
			
//			Yii::info(VarDumper::dumpAsString($model)); 
//			Yii::error('kk', 0);
//			Yii::debug('start calculating average revenue');

//			return $this->goHome();
            if ($user = $model->signup()) {
 //               if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
 //               }
            }
        }
 
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
