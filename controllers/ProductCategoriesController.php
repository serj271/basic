<?php

namespace app\controllers;
use yii\helpers\VarDumper; 
//use app\models\form\ProductForm;
use app\models\ProductCategories;
use app\models\Product;
use yii\base;
use yii\db\Query;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class ProductCategoriesController extends \yii\web\Controller
{
    public function actionIndex()
    {
		$categories = ProductCategories::find()
			->indexBy('id')
			->asArray()
			->all();
        return $this->render('index',['categories'=>$categories]);
    }

    public function actionView($category_id)
    {
		$category = ProductCategories::findOne($category_id);
		if($category == NULL) throw new \yii\web\NotFoundHttpException("Category not found");
		
		$products = $category->getProducts()->all();
        return $this->render('view',['products'=>$products]);
    }

}
