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
use app\models\ProductPhoto;
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
class ProductPhotoController extends Controller
{
	
	public $table_name = 'product';
	    
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
		
		$photos = ProductPhoto::find()
			->indexBy('id')
			->asArray()
			->all();
			
//		Yii::info(VarDumper::dumpAsString($photos));
		foreach ($photos as $photo){
			$id = $this->ansiFormat($photo['id'], Console::FG_YELLOW);
			$product_id = $this->ansiFormat($photo['product_id'], Console::FG_YELLOW);
			$path_fullsize = $this->ansiFormat($photo['path_fullsize'], Console::FG_YELLOW);
			$path_thumbnail = $this->ansiFormat($photo['path_thumbnail'], Console::FG_YELLOW);
			echo "photo_id ".$id." product_id ".$product_id.' path_fullsize '.$path_fullsize.' path_thumbnail '.$path_thumbnail."\n";
		}
		return ExitCode::OK;
	}
	
	public function actionAddOne($id=1, $path_fullsize)
	{//product-photo/add-one <product_id>
		$product = Product::findOne($id);
		if($product == NULL){
			echo "not product found $id\n";
			return ExitCode::OK;
		}
			try{
				$photo = new ProductPhoto();
				$modelAttributes = $photo->attributeTypes;
				/* $attributes = array_keys($photo->getAttributes());
				foreach($modelAttributes as $key=>$value){
					if($value == 'integer'){
						$photo[$key] = $id;
					} elseif($value == 'string'){
						$photo[$key] = $key.'_'.$id;
					}
				} */
//				unset($photo->id);
				$path_thumbnail = $path_fullsize;
				$photo->path_fullsize = '/img/product/'.$path_fullsize;
				$info = pathinfo(@web.'/product/'.$path_fullsize);
//				Yii::info(VarDumper::dumpAsString($info));
				$file_path = \Yii::getAlias('@app').'/'.@web.'/img/product/'.$path_fullsize;
//				Yii::info(VarDumper::dumpAsString());
//				Yii::info(VarDumper::dumpAsString(file_exists($file_path)));
				if(!file_exists($file_path)){
					echo "not file found $file_path\n";
					return ExitCode::OK;
				}
				$photo->path_thumbnail = '/product/thumbnail/'.$path_thumbnail;
				$photo->product_id = $id;
				$photo->scenario = ProductPhoto::SCENARIO_INSERT;
				if ($photo->validate()) {
					$photo->save();
					echo "photo add $photo->id\n";
				} else {				
					$errors = $photo->errors;
					foreach($errors as $key=>$value){
						echo "$key=>$value[0]\n";
					}
					/* $message_error = $this->ansiFormat($errors['path_fullsize'][0], Console::BOLD);
					echo $message_error."\n";
					Yii::info(VarDumper::dumpAsString($attributes)); */					
				}				
			} catch(IntegrityException $e){
				Yii::info(VarDumper::dumpAsString($e));
//				echo $e->getCode();
//				echo $e->getMessage()."\n";
				$message_error = $this->ansiFormat($e->errorInfo[2], Console::BOLD);
				echo $message_error."\n";
			}					
		return ExitCode::OK;
	}
	
	public function actionDeleteOne($id=1){//product-photo/delete-one <id>
		
			try{
				$model = ProductPhoto::findOne($id);
				if($model){
					$file_path = \Yii::getAlias('@app').'/'.@web.'/img'.$model->path_fullsize;
	//				Yii::info(VarDumper::dumpAsString());
	//				Yii::info(VarDumper::dumpAsString(file_exists($file_path)));
					if(!file_exists($file_path)){
						echo "not file found $file_path\n";
						return ExitCode::OK;
					}
					unlink($file_path);
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
		$photo = ProductPhoto::findOne($id);
		if($photo == NULL){
			echo "id photo not found\n";
			return ExitCode::OK;
		}
		$model = new ProductPhoto();
		$attributes = $model->getAttributes();
		foreach(array_keys($attributes) as $key){
			echo "$key => ".$this->ansiFormat($photo[$key], Console::FG_YELLOW)."\n";
		}

		$product = $photo->getProduct()->one();//active query to single last row of result

		$attributes = $product->attributes;
		if(count($attributes) != 0){
			echo "product name -----".$product->getOldAttributes()['name']."\n";//from public method name
			foreach($product->getOldAttributes() as $key=>$value){
				echo "$key => ".$this->ansiFormat($value, Console::FG_YELLOW)."\n";
			}	
		}
		return ExitCode::OK;
	}
}