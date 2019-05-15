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
    // The command "yii example/create test" will call "actionCreate('test')"
    public function actionCreate($name) {}

    // The command "yii example/index city" will call "actionIndex('city', 'name')"
    // The command "yii example/index city id" will call "actionIndex('city', 'id')"
    public function actionIndex($category='', $order = 'name') {
		/* if () {
			echo "A problem occurred!\n";
			return ExitCode::UNSPECIFIED_ERROR;
		} */
    // do something
//		$product = $this->ansiFormat('product', Console::FG_YELLOW);
//		echo "Hello, my name is $product.\n";
		$product = Product::findOne(1);
		if ($product === null) {
			return ExitCode::UNSPECIFIED_ERROR;
		} else {
			$product_name = $this->ansiFormat($product->name, Console::FG_YELLOW);
			echo "product name $product_name\n";
		}
		
		
		
		
		return ExitCode::OK;
	}
	
	public function actionGetall() {
		/* if () {
			echo "A problem occurred!\n";
			return ExitCode::UNSPECIFIED_ERROR;
		} */
    // do something
//		$product = $this->ansiFormat('product', Console::FG_YELLOW);
//		echo "Hello, my name is $product.\n";
//		$products = Product::find();
		$products = Yii::$app->db->createCommand('SELECT * FROM `products`')
			->queryAll();
	/* 	
		if ($product === null) {
			return ExitCode::UNSPECIFIED_ERROR;
		} else {
			$product_name = $this->ansiFormat($product->name, Console::FG_YELLOW);
			echo "product name $product_name\n";
		} */
		
		
		
		
		return ExitCode::OK;
	}

    // The command "yii example/add test" will call "actionAdd(['test'])"
    // The command "yii example/add test1,test2" will call "actionAdd(['test1', 'test2'])"
    public function actionAdd(array $name) { }
}