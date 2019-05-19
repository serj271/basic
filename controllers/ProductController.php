<?php

namespace app\controllers;
use yii\helpers\VarDumper; 
use app\models\Product;
use yii\base;
use yii\db\Query;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class ProductController extends \yii\web\Controller
{
//	public $layout='your-other-layout';
    public function actionEdit()
    {
        return $this->render('edit');
    }

    public function actionIndex($id)
    {
		$test_tmp = $this->render('index.tpl',['param1'=>0, 'param2'=>22]);
		if($id){
			$product = Product::findOne($id);
			$products = Product::find()
				->orderBy('id')
				->all();
			$this->view->title = $product->title;
//			Yii::info(VarDumper::dumpAsString($products));
			return $this->render('index',['product'=>$product,'products'=>$products,'tmp'=>$test_tmp]);
		} else {
			return $this->render('index');
		}
		
    }

    public function actionView()
    {
//		$this->layout = 'home';
        return $this->render('view');
    }

}
