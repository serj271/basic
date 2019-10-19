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
use app\models\ProductCategories;
use yii\helpers\ArrayHelper;

class ProductController extends \yii\web\Controller
{
//	public $layout='your-other-layout';
    public function actionEdit()
    {
        return $this->render('edit');
    }

    public function actionIndex_()
    {
		$test_tmp = $this->render('index.tpl',['param1'=>0, 'param2'=>22]);
//		if($id){
//			$product = Product::findOne(1);
			$products = Product::find()
				->orderBy('id')
				->all();
			$this->view->title = 'product';
//			Yii::info(VarDumper::dumpAsString($products));
			return $this->render('index',['products'=>$products,'tmp'=>$test_tmp]);
//		} else {			
//			return $this->render('index');
//		}		
    }
	public function actionIndex(){
		$products = [];
		$products = Product::find()
				->orderBy('id')
//				->asArray()
				->all();
		$model = Product::findOne(1);
		$this->view->title = 'product';
//		Yii::info($products);
		$test_tmp = $this->render('index.tpl',['param1'=>0, 'param2'=>22]);
		return $this->render('index', ['products'=>$products]);
//		return $this->render('index', ['products'=>$products,'tmp'=>$test_tmp,'model'=>$model]);
	}

    public function actionView($uri)
    {
//		$this->layout = 'home';
		$product = Product::find()->where(['uri' => $uri])->one();
		if($product == NULL) throw new \yii\web\NotFoundHttpException("Product not found");
		$categories = $product->category;
		$categories_id = ArrayHelper::map($categories,'id','name');
		$breadcrumbs = [];
		foreach($categories_id as $key=>$value){
			$breadcrumbs[] = ProductCategories::reverse_tree($key);
		}
		
		$route = Yii::$app->getUrlManager()->createUrl('categories');
		$links = [];
		if(count($breadcrumbs)){
			foreach ($breadcrumbs[0] as $breadcrumb){
				$links[] = ['label'=>$breadcrumb['label'], 'url'=>$route.$breadcrumb['url']];
			}
		}		
		return $this->render('view',[
			'product'=>$product->getOldAttributes(),
			'photos'=>$product->photos,
			'breadcrumbs' => $links,
		]);		
        
    }
	/* public function actionCreate()
    {
        $model = new ProductForm();
        $model->product = new Product;
        $model->product->loadDefaultValues();
        $model->setAttributes(Yii::$app->request->post());
        
        if (Yii::$app->request->post() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Product has been created.');
            return $this->redirect(['update', 'id' => $model->product->id]);
        }
        return $this->render('create', ['model' => $model]);
    } */
    
	public function actionJson()
	{
		$models = Product::find()->all();
		$data = array_map(function ($model) {return $model->attributes;},$models);		
		$response = Yii::$app->response;
		$response->format = Response::FORMAT_JSON;
		$response->data = $data;
		return $response;
	}

}
