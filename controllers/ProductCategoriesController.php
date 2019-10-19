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
			->where(['parent_id' => 0])
			->indexBy('id')
			->asArray()
			->all();
//		$tree = ProductCategories::full_tree($categories[1]['id']);
//		Yii::info(VarDumper::dumpAsString($tree));
        return $this->render('index',['categories'=>$categories]);
    }

    public function actionView($uri)
    {
		$category = ProductCategories::find()->where(['uri' => $uri])->one();
		$products = $category->products;
//		Yii::info(VarDumper::dumpAsString($tree));
//		if($category == NULL) throw new \yii\web\NotFoundHttpException("Category not found");
		
//		$products = $category->getProducts()->all();
//        return $this->render('view',['products'=>$products]);
		$tree = ProductCategories::full_tree($category->id);
		$children = \yii\helpers\ArrayHelper::getValue($tree, '0.id');
//		Yii::info(VarDumper::dumpAsString($tree));
		return $this->render('view', [
			'category' => $category,
			'breadcrumbs' => ProductCategories::reverse_tree($category->id),
			'children' => $tree,
			'products' => $products
		]);
    }

}
