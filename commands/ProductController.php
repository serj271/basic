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
			->select('product.*')
			->joinWith('photos ph', 'INNER JOIN')				
			->indexBy('id')
			->orderBy('ph.id')
//			->asArray()
			->all();
		$attributes_name = $model->getAttributes();
//		Yii::info(VarDumper::dumpAsString($products));
//		Yii::info(VarDumper::dumpAsString($model->attributeTypes));		
//		Yii::info(VarDumper::dumpAsString($model->getActiveValidators()));//rules()
		$message = '';
		if(count($products) !== 0){
			foreach ($products as $product){
//				Yii::info(VarDumper::dumpAsString($product->attributes));
				foreach(array_keys($attributes_name) as $key){
					echo "$key => ".$this->ansiFormat($product->getOldAttributes()[$key], Console::FG_YELLOW)."\n";
				}
				$photos = $product->photos;
//				Yii::info(VarDumper::dumpAsString($photos[0]->getOldAttributes()));
				foreach($photos as $photo){
					foreach ($photo as $key=>$value){
						echo "$key => ".$this->ansiFormat($value, Console::FG_YELLOW)."\n";
					}					
				}
//					$path_fullsize = $product->photos[0]->path_fullsize;
//					echo "photo path_fullsize ".$photo['path_fullsize'].".\n";
//					echo "photo path_fullsize ".$photo['path_thumbnail'].".\n";					
			}
		}
//		$products = Product::find()->joinWith('photos', false, 'INNER JOIN')->all();
//		Yii::info(VarDumper::dumpAsString($products[0]->photos[0]->path_fullsize));
//		Yii::info(VarDumper::dumpAsString(\Yii::$app->params['thumbnail.size']));//from params config
		return ExitCode::OK;
	}
	
	public function actionAddOne($id=1){//product-photo/add-one <product_id>
		$product = Product::findOne($id);
		/* if($product == NULL){
			echo "not product found $id\n";
			return ExitCode::OK;
		}	 */		
			try{
				$product = new Product();
//				$attributes = array_keys($photo->getAttributes());
				$product->id = $id;
				$product['name'] = 'name_'.$id;
				$product->description = 'description_'.$id;
				$product->uri = 'uri_'.$id;
				$product->visible = 1;
				
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
				
		return ExitCode::OK;
	}
	
	public function actionDeleteOne($id=1){//product/add-one <id>
		
			try{
				$model = Product::findOne($id);
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
		$product = Product::find($id)
			->with('photos')
			->where(['id'=>$id])
			->one();	
		if($product == NULL){
			echo "not found product id $id\n";
			return ExitCode::OK;
		}
		$model = new Product();
		$attributes = $model->getAttributes();
		foreach(array_keys($attributes) as $key){
			echo "$key => ".$this->ansiFormat($product->getOldAttributes()[$key], Console::FG_YELLOW)."\n";
		}
		$query = new Query();
		$query
			->select(['product.*','product_photo.*',new yii\db\Expression('DATE_FORMAT(product.created_at, "%Y-%m-%d") as d')])
			->from('product')
			->leftJoin('product_photo','product_photo.product_id')
			->where(['product.id'=>$id])
			->orderBy('product.id DESC');
//			->limit(1);\\one
//		$command = $query->createCommand();
//		$rows = $command->queryAll();		
//		Yii::info(VarDumper::dumpAsString($rows));		
//		Yii::info(VarDumper::dumpAsString($model->getActiveValidators()));//rules()
		$rows = $query->all();
		Yii::info(VarDumper::dumpAsString($rows));
		foreach($rows as  $row){
			foreach($row as $key=>$value){
				echo "$key => ".$this->ansiFormat($value, Console::FG_YELLOW)."\n";
			}				
		}		
		return ExitCode::OK;
	} 

}
