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
use yii\db\ActiveRecord;
//use yii\console\ErrorHandler;
use yii\db\IntegrityException;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ProductController extends Controller
{
	public $id=1;
	public $table_name = 'products';
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
    // The command "yii example/create test" will call "actionCreate('test')"
    public function actionCreate() {}

    // The command "yii example/index city" will call "actionIndex('city', 'name')"
    // The command "yii example/index city id" will call "actionIndex('city', 'id')"
    public function actionIndex() {
		/* if () {
			echo "A problem occurred!\n";
			return ExitCode::UNSPECIFIED_ERROR;
		} */
    // do something
//		$product = $this->ansiFormat('product', Console::FG_YELLOW);
//		echo "Hello, my name is $product.\n";
		$product = Product::findOne($this->id);
		if ($product === null) {
			return ExitCode::UNSPECIFIED_ERROR;
		} else {
			$product_name = $this->ansiFormat($product->name, Console::FG_YELLOW);
			echo "product name $product_name\n";
		}
		return ExitCode::OK;
	}
	
	public function actionGetAll() {//product/get-all
//		$products = Product::find();
		$products = Yii::$app->db->createCommand('SELECT * FROM `products`')			
			->queryAll();//get array || queryOne(); 
		foreach ($products as $product){
			$product_name = $this->ansiFormat($product['name'], Console::FG_YELLOW);
			$product_uri = $this->ansiFormat($product['uri'], Console::FG_YELLOW);
			$product_desc = $this->ansiFormat($product['description'], Console::FG_YELLOW);
			$product_foto_id = $this->ansiFormat($product['primary_photo_id'], Console::FG_YELLOW);
			$product_model = Product::findOne($product['id']);
			$photos = $product_model->getProductPhotos();
			Yii::info(VarDumper::dumpAsString($photos));
			echo "product name $product_name id ".$product['id']." product uri ".$product_uri.' description '.$product_desc.' foto_id '.$product_foto_id."\n";
		}
		return ExitCode::OK;
	}
	public function actionGetNames() {//product/get-names
		$query = (new \yii\db\Query());
		$query->from('products')
			->orderBy('name ASC');
		$products = $query->all();
		foreach ($products as $product){
			$product_name = $this->ansiFormat($product['name'], Console::FG_YELLOW);
			echo "product name $product_name id ".$product['id']."\n";
		}
		return ExitCode::OK;
	}
	public function actionGetName($name){//product/get-name <name>
		$product = Product::findOne(['name'=>$name]);
		$product_id = $this->ansiFormat($product['id'], Console::FG_YELLOW);
			echo "product id $product_id\n";
		return ExitCode::OK;
	}
	
	public function actionGetUri($uri){//product/get-name <name1, name2>
		$query = (new \yii\db\Query());
		$query->select([
			'product_id' => 'id',
			'name_product' => 'name']
			)
			->from('products')
			->where(['=','uri',$uri]);
			
//			->addParams([':id' => 1]);
		$product = $query->one();//all
 		$nameProduct = $this->ansiFormat($product['name_product'], Console::FG_YELLOW);
		echo "name-product $nameProduct  id ".$product['product_id']."\n";
		return ExitCode::OK;
	}
	
	public function actionAddOne($id=1){//product/add-one <id>
		if($id){
			try{
					\Yii::$app->db
				->createCommand()
				->insert('products', [
					'id' => $id,
					'name' =>'name product'.$id,
					'uri'  => 'uri'.$id,
					'description'  => 'description product'.$id,
					'primary_photo_id'  => $id
					/* 'avg_review_rating'  => Schema::TYPE_INTEGER,
					'visible' =>  Schema::TYPE_TINYINT.' NOT NULL DEFAULT 1' */
				])
				->execute();
				echo "product add\n";
			} catch(IntegrityException $e){
//				Yii::info(VarDumper::dumpAsString($e));
//				echo $e->getCode();
//				echo $e->getMessage()."\n";
				$message_error = $this->ansiFormat($e->errorInfo[2], Console::BOLD);
				echo $message_error."\n";
			}			
		}			
		return ExitCode::OK;
	}
	public function actionUpdateName(array $array){//product/update-name <id,name>
//		if($id){
			try{
					\Yii::$app->db
						->createCommand()
						->update('products', [
						'name'=>$array[1]
						
						], "id=:id")
					->bindValue(':id', (int) $array[0])
					->execute();
				echo "product update\n";
			} catch(IntegrityException $e){
//				Yii::info(VarDumper::dumpAsString($e));
//				echo $e->getCode();
//				echo $e->getMessage()."\n";
				$message_error = $this->ansiFormat($e->errorInfo[2], Console::BOLD);
				echo $message_error."\n";
			}			
//		}			
		return ExitCode::OK;
	}
	public function actionUpdateDesc(array $array){//product/update-desc <id,desc>
			try{
					$product = Product::find()
						->where(['id' => $array[0]])
						->one();
					$product->description = $array[1];
					$product->update();
				echo "product update\n";
			} catch(IntegrityException $e){
//				Yii::info(VarDumper::dumpAsString($e));
//				echo $e->getCode();
//				echo $e->getMessage()."\n";
				$message_error = $this->ansiFormat($e->errorInfo[2], Console::BOLD);
				echo $message_error."\n";
			}					
		return ExitCode::OK;
	}
	public function actionUpdatePrimaryFotoId(array $array){//product/update-primary-foto-id <id,primary-foto-id>
			$product = Product::find()
						->where(['id' => $array[0]])
						->one();
			if($product){					
				$product->primary_photo_id = (int) $array[1];
				
				if($product->validate()){
					$product->update();
					echo "product update saccess\n";			

				} else {
					Yii::info(VarDumper::dumpAsString($product->getErrors()));
					$errors = $product->errors;
					/* $error_message='';
					foreach($errors as $key=>$value){
						$error_message +="$key=>$value[0]";
					}	*/
					$key = array_keys($errors)[0];
					$value = array_values($errors)[0];
					$message_error = $this->ansiFormat($key.' => '.$value[0], Console::BOLD);
					echo $message_error."\n"; 
				}
//				Yii::info(VarDumper::dumpAsString($e));
//				echo $e->getCode();
//				echo $e->getMessage()."\n";
//				$message_error = $this->ansiFormat($e->errorInfo[2], Console::BOLD);
//				echo $message_error."\n";			
			} else {
				echo "product not found\n";
			}
							
		return ExitCode::OK;
	}
	public function actionDeleteOne($id=1){//product/add-one <id>
		
			try{
				$product = Product::findOne($id);
				if($product){
					$product->delete();
					echo "product delete $id\n";
				} else {
					echo "not product with id => ".$id;
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
    public function actionAdd(array $name) { }
	
	public function getProductPhotos() { 
		return $this->hasMany(Product::className(), ['product_id' => 'id']); 
	}
	
	public function getProduct()
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
    }
}