<?php

namespace app\controllers;
use yii\helpers\VarDumper; 
use app\models\form\ProductForm;
use app\models\Product;
use yii\base;
use yii\db\Query;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'app\models\User';

    public function actionCreate()
    {
        return $this->render('create');
    }

    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionDetail()
    {
        return $this->render('detail');
    }

    public function actionEdit()
    {
        return $this->render('edit');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionSignup()
    {
        return $this->render('signup');
    }

}
