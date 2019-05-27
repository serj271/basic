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
use app\models\ProductPhoto;
use yii\db\ActiveRecord;
//use yii\console\ErrorHandler;
use yii\db\IntegrityException; 

class ProductController extends Controller
{
	public $table_name = 'product';
	private $_product;
    private $_photos;
    
    public function options($actionID)
    {
        return ['id'];
    }
    
    public function optionAliases()
    {
        return ['id' => 'id'];
    }
	protected function beforeSave($insert) {
// Do whatever.
		return parent::beforeSave($insert);
	}
	protected function beforeValidate() {
		$this->content = trim($this->content);
		return parent::beforeValidate();
	} 
    public function actionIndex()
    {
        return ExitCode::OK; 
    }
	public function actionGetAll() {//product/get-all
		$model = new Product();
		$products = Product::find()	
			->indexBy('id')
			->all();
		$attributes = $model->getAttributes();
		Yii::info(VarDumper::dumpAsString($model->attributeTypes));
		
		Yii::info(VarDumper::dumpAsString($model->getActiveValidators()));//rules()
		$message = '';
		if(count($products) !== 0){
			foreach(array_keys($attributes) as $key){
				$message .= $products[0][$key];
			}
		}
		
//		Yii::info(VarDumper::dumpAsString($photos));
		/* foreach ($products as $product){
			$id = $this->ansiFormat($product['id'], Console::FG_YELLOW);
			$name = $this->ansiFormat($product['name'], Console::FG_YELLOW);
			$uri = $this->ansiFormat($uri['path_fullsize'], Console::FG_YELLOW);
			$path_thumbnail = $this->ansiFormat($product['path_thumbnail'], Console::FG_YELLOW);
			$path_thumbnail = $this->ansiFormat($product['path_thumbnail'], Console::FG_YELLOW);
			$path_thumbnail = $this->ansiFormat($product['path_thumbnail'], Console::FG_YELLOW);
			echo "photo_id ".$id." product_id ".$product_id.' path_fullsize '.$path_fullsize.' path_thumbnail '.$path_thumbnail."\n";
		} */
		return ExitCode::OK;
	}
	
	public function actionAddOne($id=1){//product-photo/add-one <product_id>
		$product = Product::findOne($id);
		/* if($product == NULL){
			echo "not product found $id\n";
			return ExitCode::OK;
		}	 */
		if($id){
			try{
				$product = new Product();
//				$attributes = array_keys($photo->getAttributes());
				$product->id = $id;
				$product['name'] = 'name'.$id;
				$product->description = 'description'.$id;
				$product->uri = 'uri'.$id;
				$product->visible = $id;
				
				if ($product->validate()) {
					$last_id = $product->save();
					echo "product add $product->id $last_id\n";
				} else {				
					$errors = $product->errors;
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
		}			
		return ExitCode::OK;
	}
	
	public function actionDeleteOne($id=1){//product/add-one <id>
		
			try{
				$model = ProductPhoto::findOne($id);
				if($model){
					$model->delete();
					echo "model delete $id\n";
				} else {
					echo "not model with id => ".$id;
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
		$photo = ProductPhoto::findOne($id);
		if($photo == NULL){
			echo "id photo not found\n";
			return ExitCode::OK;
		}
			
		try {						
			$product_id = $this->ansiFormat($photo['product_id'], Console::FG_YELLOW);
			$path_fullsize = $this->ansiFormat($photo['path_fullsize'], Console::FG_YELLOW);
			$path_thumbnail = $this->ansiFormat($photo['path_thumbnail'], Console::FG_YELLOW);
			
			echo "photo id $id product_id uri ".$product_id.' path_fullsize '.$path_fullsize.' path_thumbnail '.$path_thumbnail."\n";
//			echo "photo id ".$photos[0]['id']."\n";
			
		} catch(IntegrityException $e){
			Yii::info(VarDumper::dumpAsString($e));
				echo $e->getCode();
				echo $e->getMessage()."\n";
			$message_error = $this->ansiFormat($e->errorInfo[2], Console::BOLD);
			echo $message_error."\n";
		}
		return ExitCode::OK;
	} 

}
