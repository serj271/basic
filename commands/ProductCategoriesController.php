<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use Yii;
use yii\base;
use yii\db\Query;
use yii\helpers\VarDumper; 
use app\models\Product;
use app\models\ProductCategories;
use yii\db\ActiveRecord;
//use yii\console\ErrorHandler;
use yii\db\IntegrityException;
//   \yii\helpers\VarDumper::dump

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ProductCategoriesController extends Controller
{
	
	public $table_name = 'product_categories';
	    
    public function options($actionID)
    {
        return ['id'];
    }
    
    public function optionAliases()
    {
        return ['id' => 'id'];
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
		
		$categories = ProductCategories::find()
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
	
	public function actionAddOne($name,$parent_id)
	{//product-photo/add-one <product_id>
//		$category = ProductCategories::findOne($id);
//		Yii::info(VarDumper::dumpAsString($category));
		
			try{
				$model = new ProductCategories();
				$model->uri = 'uri_'.$name;
	
				$model->name =$name;
				$model->description = 'description '.$name;
				$model->order = 'order '.$name;
				$model->parent_id = $parent_id;
				$model->save(false);
				
			} catch(IntegrityException $e){
				Yii::info(VarDumper::dumpAsString($e));
//				echo $e->getCode();
//				echo $e->getMessage()."\n";
				$message_error = $this->ansiFormat($e->errorInfo[2], Console::BOLD);
				echo $message_error."\n";
			}					
		return ExitCode::OK;
	}
	
	public function actionDeleteOne($id=1){//product-categories/delete-one <id>
		
			try{
				$model = ProductCategories::findOne($id);
				if($model){
	//				$file_path = \Yii::getAlias('@app').'/'.@web.'/img'.$model->path_fullsize;
	//				Yii::info(VarDumper::dumpAsString());
	//				Yii::info(VarDumper::dumpAsString(file_exists($file_path)));
					/* if(!file_exists($file_path)){
						echo "not file found $file_path\n";
						return ExitCode::OK;
					}
					unlink($file_path);*/
					$model->delete();
					echo "model delete $id\n";
				} else {
					echo "not model with id => $id \n";
				}				
				
			} catch(IntegrityException $e){
				Yii::info(VarDumper::dumpAsString($e));
//				echo $e->getCode();
//				echo $e->getMessage()."\n";
				$message_error = $this->ansiFormat($e->errorInfo[2], Console::BOLD);
				echo $message_error."\n";
			}			
//		$this->stdout("Waiting on important thing to happen...\n",Console::BOLD);			
		return ExitCode::OK;
	}
    // The command "yii example/add test" will call "actionAdd(['test'])"
    // The command "yii example/add test1,test2" will call "actionAdd(['test1', 'test2'])"
 
		
	/* public function getProduct()
    {
        return $this->_product;
    }
	
	public function setProduct($product)
    {
        if ($product instanceof Product) {
            $this->_product = $product;
        } else if (is_array($product)) {
            $this->_product->setAttributes($product);
        }
    } */
	
	public function actionGetOne($id){			
//		Yii::info(VarDumper::dumpAsString($model));
//		Yii::info(VarDumper::dumpAsString($photo->getDirtyAttributes()));
//		Yii::info(VarDumper::dumpAsString($photo->getProduct()));
		$category = ProductCategories::findOne($id);
		if($category == NULL){
			echo "id {$id} category not found\n";
			return ExitCode::OK;
		}
		$model = new ProductCategories();
		$attributes = $model->getAttributes();
		foreach(array_keys($attributes) as $key){
			echo "$key => ".$this->ansiFormat($category[$key], Console::FG_YELLOW)."\n";
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
	public function actionGetProducts($category_id){//
		$category = ProductCategories::findOne($category_id);
		if($category == NULL){
			echo "category_id {$category_id} category not found\n";
			return ExitCode::OK;
		}
		$model = new ProductCategories();
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
	public function actionAddCategory($product_id, $product_category_id){
		$category = ProductCategories::findOne($product_category_id);
		$product = Product::findOne($product_id);
		if($category == NULL){
			echo "category {$category} not foud";
			return ExitCode::OK;
		}
		if($product == NULL){
			echo "product {$product} not foud";
			return ExitCode::OK;
		}
		
		return ExitCode::OK;
	}
}