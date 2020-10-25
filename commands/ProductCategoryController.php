<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use Yii;
use yii\base;
use yii\db\Query;
use yii\helpers\VarDumper; 
use app\models\Product;
use app\models\ProductCategory;
use yii\db\ActiveRecord;
//use yii\console\ErrorHandler;
use yii\db\IntegrityException;
use yii\helpers\ArrayHelper;
use app\common\components\CurlGetHelpers;
use yii\helpers\BaseUrl; 

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ProductCategoryController extends Controller
{
	
	public $table_name = 'product_category';
	    
    public function options($actionID)
    {
        return ['id'];
    }
    
    public function optionAliases()
    {
        return ['id' => 'ID'];
    }
	
    // The command "yii example/create test" will call "actionCreate('test')"
    public function actionCreate() {}

    // The command "yii example/index city" will call "actionIndex('city', 'name')"
    // The command "yii example/index city id" will call "actionIndex('city', 'id')"
    public function actionIndex() {
		/* $product = Product::findOne($this->id);
		if ($product === null) {
			return ExitCode::UNSPECIFIED_ERROR;
		} else {
			$product_name = $this->ansiFormat($product->name, Console::FG_YELLOW);
			echo "product name $product_name\n";
		} */
		return ExitCode::OK;
	}
	
	public function actionGetAll() {//product/get-all
//		$model = new ProductPhoto();
//		$attributes = $model->getAttributes();
//		Yii::info(VarDumper::dumpAsString($model->getAttributes()));
//		Yii::info(VarDumper::dumpAsString($model->attributeTypes));
		
		$categories = ProductCategory::find()
			->indexBy('id')
			->asArray()
			->all();
			
//		Yii::info(VarDumper::dumpAsString($photos));
		foreach ($categories as $category){
			$id = $this->ansiFormat($category['id'], Console::FG_YELLOW);
			$parent_id = $this->ansiFormat($category['parent_id'], Console::FG_YELLOW);
			$description = $this->ansiFormat($category['description'], Console::FG_YELLOW);
			$name = $this->ansiFormat($category['name'], Console::FG_YELLOW);
			echo "id ".$id." parent_id ".$parent_id.' description '.$description.' name '.$name."\n";
		}
		return ExitCode::OK;
	}
	
	public function actionAddOne($id,$parent_id)
	{//product-photo/add-one <product_id>
//		$category = ProductCategories::findOne($id);
//		Yii::info(VarDumper::dumpAsString($category));
		if($id == '0'){
			echo "not set id 0\n";
			return ExitCode::OK;
		}
			try{
				$model = new ProductCategory();
				$model->uri = 'uri_'.$id.'_'.$parent_id;
				$model->setAttribute('id',$id);
	
				$model->name ='category_name_'.$id;
				$model->description = 'description '.$id;
			/*	$model->order = 'order_'.$id;*/
				$model->parent_id = $parent_id;
				$model->validate('uri');
				$message_error = '';
				if($model->hasErrors()){
					foreach($model->errors['uri'] as $key=>$value){
						$message_error .= $value;
					}
					echo $message_error."\n";
                    Yii::info(VarDumper::dumpAsString($model->errors));
//					Yii::info(VarDumper::dumpAsString(ArrayHelper::getValue($model->errors, 'uri')));
					return ExitCode::OK;					
				}
				$model->save(true);				
			} catch(IntegrityException $e){
				Yii::info(VarDumper::dumpAsString($e));
//				echo $e->getCode();
//				echo $e->getMessage()."\n";
				$message_error = $this->ansiFormat($e->errorInfo[2], Console::BOLD);
				echo $message_error."\n";
			}					
		return ExitCode::OK;
	}
	
	public function actionDeleteOne($id=1){//product-category/delete-one <id>
				$model = ProductCategory::findOne($id);
				if($model){
	//				$file_path = \Yii::getAlias('@app').'/'.@web.'/img'.$model->path_fullsize;
	//				Yii::info(VarDumper::dumpAsString());
	//				Yii::info(VarDumper::dumpAsString(file_exists($file_path)));
					/* if(!file_exists($file_path)){
						echo "not file found $file_path\n";
						return ExitCode::OK;
					}
					unlink($file_path);*/
                    try {
                        $model->delete();
                        echo "model delete $id\n";
                    } catch (IntegrityException $e) {
                        Yii::info(VarDumper::dumpAsString($e));
//				echo $e->getCode();
//				echo $e->getMessage()."\n";
                        $message_error = $this->ansiFormat($e->errorInfo[2], Console::BOLD);
                        echo $message_error . "\n";
                    }
				} else {
					echo "not model with id => $id \n";
				}
//		$this->stdout("Waiting on important thing to happen...\n",Console::BOLD);			
		return ExitCode::OK;
	}
	
	public function actionGetOne($id){			
//		Yii::info(VarDumper::dumpAsString($model));
//		Yii::info(VarDumper::dumpAsString($photo->getDirtyAttributes()));
//		Yii::info(VarDumper::dumpAsString($photo->getProduct()));
		$category = ProductCategory::findOne($id);
		if($category == NULL){
			echo "id {$id} category not found\n";
			return ExitCode::OK;
		}
		$model = new ProductCategory();
		$attributes = $model->getAttributes();
		echo $this->ansiFormat('category', Console::BOLD)."\n";
		foreach(array_keys($attributes) as $key){
			echo "$key => ".$this->ansiFormat($category[$key], Console::FG_YELLOW)."\n";
		}
		//$tree = ProductCategory::full_tree($id);
//		Yii::info(VarDumper::dumpAsString($tree));
//		$children = \yii\helpers\ArrayHelper::getValue($tree, '0.id');
		/*foreach($tree as $item)
		{
			echo "children => ".$this->ansiFormat($item['name'], Console::FG_YELLOW)."\n";
		}
		echo $this->ansiFormat('breadcrumb', Console::BOLD)."\n";
		$breadcrumb = ProductCategory::reverse_tree($id);
		foreach($breadcrumb as $item){
			echo "label =>  ".$item['label']." url =>  ".$item['url']." \n";
		}
		$products = $category->products;
		if(count($products)){
			echo $this->ansiFormat('product', Console::BOLD)."\n";
		}
		foreach ($products as $product){
			echo "name of product $product->name\n";
		}*/
		return ExitCode::OK;
	}
	public function actionUpdateParent($id, $parent_id){
		$category = ProductCategory::findOne($id);
		if($category == NULL){
			echo "id {$id} category not found\n";
			return ExitCode::OK;
		}
		$parent_old = $category->parent_id;
		$category_parent = ProductCategory::findOne($parent_id);
		if($category_parent == NULL){
			echo "parent_id {$parent_id} not found\n";
			return ExitCode::OK;
		}		
		$category->parent_id = $parent_id;
		$latest_id = $category->save(true);
//		$category = ProductCategories::findOne($latest_id);
		echo "update parent {$id} category from $parent_old to  $parent_id\n";
		return ExitCode::OK;
	}
	public function actionGetProducts($category_id){//
		$category = ProductCategory::findOne($category_id);
		if($category == NULL){
			echo "category_id {$category_id} category not found\n";
			return ExitCode::OK;
		}
		$model = new ProductCategory();
		$attributes = $model->getAttributes();
		foreach(array_keys($attributes) as $key){
			echo "$key => ".$this->ansiFormat($category[$key], Console::FG_YELLOW)."\n";
		}
		$products = $category->getProducts()->all();

		foreach($products as $product){
			echo "id product ".$this->ansiFormat($product->id, Console::FG_YELLOW)."\n";
			echo "name product ".$this->ansiFormat($product->name, Console::FG_YELLOW)."\n";
		}
	/* 	$product = $photo->getProduct()->one();//active query to single last row of result

		$attributes = $product->attributes;
		if(count($attributes) != 0){
			echo "product name -----".$product->getOldAttributes()['name']."\n";//from public method name
			foreach($product->getOldAttributes() as $key=>$value){
				echo "$key => ".$this->ansiFormat($value, Console::FG_YELLOW)."\n";
			}	
		} */
		return ExitCode::OK;
	}
	public function actionCurlGetAll()
	{
		$uri = Yii::$app->urlManager->createUrl(['json','controller'=>'json-product-categories', 'action'=>'index']);
		$url = 'http://192.168.1.1'.$uri;
//		$key = Yii::$app->request->csrfParam;
//		$value = Yii::$app->request->csrfToken;
		list($categories, $getinfo) = CurlGetHelpers::get($url, null);
		if($getinfo['http_code'] != 200){
//			Yii::info(VarDumper::dumpAsString($getinfo)); 
			echo "code {$getinfo['http_code']}\n";
			return ExitCode::OK;
		}
		if(count($categories) !== 0){
			if(is_array($categories)){
				foreach ($categories as $category){
					foreach($category as $key => $value){
						echo "$key => ".$this->ansiFormat($value, Console::FG_YELLOW)."\n";
					}
				}	
			}			
		}
//		echo $data;
//		echo Yii::$app->urlManager->createUrl(['json','controller'=>'json-product', 'action'=>'index'])."\n"; 
		return ExitCode::OK;
	}
	public function actionCurlGetOne($id=null)
	{
//		$session = Yii::$app->session->get('session');
		$uri = Yii::$app->urlManager->createUrl(['json','controller'=>'json-product-categories', 'action'=>'view']);
		$url = 'http://192.168.1.1'.$uri;
		list($product, $getinfo) = CurlGetHelpers::get($url, $id);
		if($getinfo['http_code'] != 200)
		{
			echo "code {$getinfo['http_code']}\n";
			return ExitCode::OK;
		}
		
		foreach($product as $key => $value){
			echo "$key => ".$this->ansiFormat($value, Console::FG_YELLOW)."\n";
		}
		return ExitCode::OK;
	}
	public function actionCurlGetProducts($id=null)
	{
//		$session = Yii::$app->session->get('session');	
		$uri = Yii::$app->urlManager->createUrl(['json','controller'=>'json-product-categories', 'action'=>'get-products']);
		$url = 'http://192.168.1.1'.$uri;
		list($products, $getinfo) = CurlGetHelpers::get($url, $id);
		if($getinfo['http_code'] != 200)
		{
			echo "code {$getinfo['http_code']}\n";
			return ExitCode::OK;
		}
		foreach ($products as $product)
		{
			foreach($product as $key => $value){
				echo "$key => ".$this->ansiFormat($value, Console::FG_YELLOW)."\n";
			}
		}		
		return ExitCode::OK;
	}
	
}