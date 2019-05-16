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
use yii\helpers\VarDumper; 
use app\models\Product;
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
	
	public function actionGetNames(array $array){//product/get-name <name1, name2>
		foreach ($array as $name){
			$product = Product::findOne(['name'=>$name]);
			$product_id = $this->ansiFormat($product['id'], Console::BOLD);
			echo "product id $product_id\n";
		}
					
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
	public function actionUpdateName($id=1){//product/add-one <id>
		if($id){
			try{
					\Yii::$app->db
						->createCommand()
						->update('products', [
						
					], '1 = 1')
				->execute();
				echo "product update\n";
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
}