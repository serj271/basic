<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\NewsForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\CommentModel;
use yii\helpers\VarDumper;



class CommentController extends Controller
{
    /**
     * {@inheritdoc}
     */
/*    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
*/
    /**
     * {@inheritdoc}
     */
    public function actionIndex()
    {
		$model = new CommentModel();
		Yii::info($model->getAttributeLabel('user_id'));
		Yii::info($model->find()->all()[0]['comment']);//find()->asArray()->all();$pages = Page::find()->joinWith('comments')
//->orderBy('comment.date_entered DESC')->all();
//		Yii::info(VarDumper::dumpAsString($model->find()->all()[0]->oldattributes['comment']));
		$num = 23;
		$comments = $model->find()->all()[0]->oldattributes;
//		$post = \app\models\Post::findOne(100);
//		$post = \app\models\CommentModel::findOne(100);
//		$array = $post->attributes;
//		Yii::info(VarDumper::dumpAsString($array));
        return $this->render('index',['num' => $num, 'comments'=>$comments]);
    }
	/* public $defaultAction = ’home’;
	public function actionHome()
	{
		return $this->render(’home’);
	} */
    
	
	
}
