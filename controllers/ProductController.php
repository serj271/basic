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

    public function actionView($id)
    {
//		$this->layout = 'home';
		$product = Product::findOne($id);
		if($product == NULL) throw new \yii\web\NotFoundHttpException("Product not found");
		
		return $this->render('view',['product'=>$product->getOldAttributes(),'photos'=>$product->photos]);
		
        
    }
	public function actionCreate()
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
    }
    
    public function actionUpdate($id)
    {
        $model = new ProductForm();
        $model->product = $this->findModel($id);
        $model->setAttributes(Yii::$app->request->post());
        
        if (Yii::$app->request->post() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Product has been updated.');
            return $this->redirect(['update', 'id' => $model->product->id]);
        }
        return $this->render('update', ['model' => $model]);
    }
    
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new HttpException(404, 'The requested page does not exist.');
    }
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
