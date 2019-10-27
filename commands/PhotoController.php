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
use app\models\ProductCategories;
use yii\db\ActiveRecord;
use yii\console\ErrorHandler;
use yii\db\IntegrityException;
use yii\helpers\ArrayHelper;
use app\common\components\CurlGetHelpers;
use yii\helpers\BaseUrl;
use yii\helpers\FileHelper;
//use dastin\csv\models\CsvData;
use app\models\CsvBasic;

class PhotoController extends Controller
{
	public $table_name = 'product_photo';
	    
    public function options($actionID)
    {
        return ['id'];
    }
    
    public function optionAliases()
    {
        return ['id' => 'id'];
    }
    public function actionIndex()
    {
		$filename = realpath(Yii::$app->basePath).'/web/uploads/csv.csv';

		if (file_exists($filename)) {
			echo "The file $filename exists\n";
		} else {
			echo "The file $filename does not exist \n";
		}
//		$file = new \SplFileObject(Yii::$app->basePath.'/web/uploads/csv.csv');
		$model = new CsvBasic([
			'filename' =>realpath(Yii::$app->basePath).'/web/uploads/csv.csv',
			'pagination'=> [
				'pageSize'=>200,
				
			]
		]);
//		$model = new CsvData();
		$model->setCsvControl("	",' ','\\');
//		Yii::info(VarDumper::dumpAsString( $model->getCsvControl()));
//		Yii::info(VarDumper::dumpAsString( $model->getColNames()));
		Yii::info(VarDumper::dumpAsString( $model->parse()));
//		Yii::info(VarDumper::dumpAsString( $model->getPageCount()));

		
		
		
		
        return ExitCode::OK;
    }

}
