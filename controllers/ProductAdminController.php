<?php

namespace app\controllers;
use app\models\ProductCategory;
use yii\helpers\VarDumper;
use app\models\ProductForm;
use app\models\ProductUpdateCategoryForm;
use app\models\Product;
use yii\base;
use yii\db\Query;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ProductCategories;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use app\models\CustomerSearch;

class ProductAdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
		$products = Product::find();
		$model = new Product();
		$attributes = $model->getAttributes();
		$this->view->title = 'product-admin';
//		Yii::info(array_keys($attributes));		
		$searchModel = new \app\models\CustomerSearch();
//		Yii::info(VarDumper::dumpAsString($_GET));
		
		$dataProvider = new ActiveDataProvider([
			'query' => $products,
			/* 'pagination' => [
				'pageSize' => 10,
			], */
		]);
		if(isset($_GET['CustomerSearch'])){
			$dataProvider = $searchModel->search(Yii::$app->request->get());
//			Yii::info(VarDumper::dumpAsString($_GET['CustomerSearch']));
//			Yii::info(VarDumper::dumpAsString($dataProvider));
		}
		return $this->render('index', [ 'dataProvider' => $dataProvider,
			'table_name'=>Product::tableName(),
			'searchModel'=>$searchModel,
			'attributes'=>$attributes
		]); 
    }

    public function actionView($id)
    {
		$product = Product::findOne($id);		
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
	
	public function actionEdit($id = null)
    {
		$model = new ProductForm();
		if ($model->load(Yii::$app->request->post())) {//ProductForm array
			$product = Product::findOne($model->attributes['id']);			
			$product->attributes = $model->attributes;
			$id = $model->attributes['id'];
			$product->validate();
			if ($product->hasErrors()) {
			// validation fails
				
				$model->addErrors($product->errors);
//				Yii::info(VarDumper::dumpAsString($model)); 
			} else {
				$product->update();
				return $this->redirect(['index']);
			}
				
//				Yii::info(VarDumper::dumpAsString($model->getAttributes())); 
				/* if ($product->updateAll($model->attributes,['=','id',$id]) !== false) {
					// update successful
				} else {
					// update failed
				}	 */			
				           
		}
		if($id != null){
			$product = Product::findOne($id);
			if($product == NULL){
				throw new \yii\web\HttpException(404,"$id product not found");
			}
			$model->attributes = $product->attributes;
			$model->id = $id;
		}
//		Yii::$app->session->setFlash('message', 'hee');
		return $this->render('edit',['model'=>$model, 'table_name'=>Product::tableName()]);	
 //       return $this->render('edit',['model'=>$model, 'table_name'=>Product::tableName()]);
    }
	
	public function actionCreate()
	{
//		$model = new ProductForm();
		$productUpdatecategoryForm = new ProductUpdateCategoryForm();
		$productUpdatecategoryForm->product = new Product();
		$productUpdatecategoryForm->productCategories = new ProductCategory();
		
		$categories = ProductCategory::getCategories();
		if (Yii::$app->request->post()) {
            
	//		Yii::info(VarDumper::dumpAsString(Yii::$app->request->post()));
//			$productUpdatecategoryForm->load(Yii::$app->request->post());
			$productUpdatecategoryForm->product->attributes = Yii::$app->request->post()['Product'];
			$productUpdatecategoryForm->productCategories = ProductCategory::findOne(Yii::$app->request->post()['ProductCategories']['id']);
//			$productUpdatecategoryForm->product->id = 26;
//			Yii::info(VarDumper::dumpAsString($productUpdatecategoryForm));
			if($productUpdatecategoryForm->save()){
				Yii::$app->getSession()->setFlash('success', 'Product has been created.');
				return $this->redirect(['index']);
			}            
			
        }

        return $this->render('create', [
			'productUpdatecategoryForm' => $productUpdatecategoryForm,
			'categories' => ArrayHelper::map($categories, 'id', 'name'),
		]);
	}	
	
	public function actionDelete($id){
		$product = Product::findOne($id);
		if($product == NULL){
			throw new \yii\web\HttpException(404,"$id product not found");
		}
//		Yii::info(VarDumper::dumpAsString($product));
		if (Yii::$app->request->post()){
//			$action = Yii::$app->request->post()['action'];
//			Yii::info(VarDumper::dumpAsString(Yii::$app->request->post()));
//			if($action =='yes'){	
				$product = Product::findOne(Yii::$app->request->post()['id']);
				$product->delete();			
//			}
			return $this->redirect(['index']);					
		}
		return $this->render('delete', [
			'product'=>$product
			
		]);
		
	}
	/* public function actionCreatecategory($id)
    {
        $productUpdatecategoryForm = new ProductUpdateCategoryForm();
        $productUpdatecategoryForm->product = $this->findModel($id);
		$productUpdatecategoryForm->productCategories = new ProductCategories();
		$categories = ProductCategories::getCategories();
//		Yii::info(VarDumper::dumpAsString($productUpdatecategoryForm));
        $productUpdatecategoryForm->setAttributes(Yii::$app->request->post());
		$productUpdatecategoryForm->setAttributes(Yii::$app->request->post());
        if (Yii::$app->request->post()) {
            Yii::$app->getSession()->setFlash('success', 'Product has been create.');
//			Yii::info(VarDumper::dumpAsString(Yii::$app->request->post()));
			$productUpdatecategoryForm->load(Yii::$app->request->post());
			$productUpdatecategoryForm->create();
//			Yii::info(VarDumper::dumpAsString($productUpdatecategoryForm));
            return $this->redirect(['product-admin']);
			
        } elseif (!Yii::$app->request->isPost) {
            $productUpdatecategoryForm->load(Yii::$app->request->get());//id=>1
//			Yii::info(VarDumper::dumpAsString(Yii::$app->request->get()));
        }
        return $this->render('createcategory', [
			'productUpdatecategoryForm' => $productUpdatecategoryForm,
			'categories' => ArrayHelper::map($categories, 'id', 'name'),
		]); 
    }*/
	public function actionUpdatecategory($id)
    {
        $productUpdatecategoryForm = new ProductUpdateCategoryForm();

        try {
            $productUpdatecategoryForm->product = $this->findModel($id);
        } catch (HttpException $e) {
            throw new \HttpException("error");
        }
        $productUpdatecategoryForm->productCategories = ProductCategory::getCategories();
	//	$productUpdatecategoryFormCategories = new ProductCategories();
		$categories = ProductCategory::getCategories();
		$selected = empty($productUpdatecategoryForm->product->category) ? $categories[0]->id : $productUpdatecategoryForm->product->category[0]->id;

//		Yii::info(VarDumper::dumpAsString($productUpdatecategoryForm));
 //       $productUpdatecategoryForm->setAttributes(Yii::$app->request->post());
		
 //       if (Yii::$app->request->post()) {
//			Yii::info(VarDumper::dumpAsString(Yii::$app->request->post()));
		/*	$productUpdatecategoryForm->load(Yii::$app->request->post());
			if($productUpdatecategoryForm->update()){
				Yii::$app->getSession()->setFlash('success', 'Product has been updated.');
				return $this->redirect(['index']);
			}	*/
//			
			
  //      } elseif (!Yii::$app->request->isPost) {
    //        $productUpdatecategoryForm->load(Yii::$app->request->get());//id=>1
//			Yii::info(VarDumper::dumpAsString(Yii::$app->request->get()));
    //    }
        return $this->render('updatecategory', [
			'productUpdatecategoryForm' =>$productUpdatecategoryForm,
			'categories' => ArrayHelper::map($categories, 'id', 'name'),
			'selected' => $selected
		]);
    }
    
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new HttpException(404, 'The requested page does not exist.');
    }
	protected function handlePostSave(ProductForm $model)
	{
		/* if ($model->load(Yii::$app->request->post())) {
			$model->upload = UploadedFile::getInstance($model, 'upload');

			if ($model->validate()) {
				if ($model->upload) {
					$filePath = 'uploads/' . $model->upload->baseName . '.' . $model->upload->extension;
					if ($model->upload->saveAs($filePath)) {
//						$model->image = $filePath;

					}
				}

				if ($model->save(false)) {
					return $this->redirect(['view', 'id' => $model->id]);
				}
			}
		} */
	} 

}
