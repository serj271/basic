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
use app\models\Parcel;
use yii\db\ActiveRecord;
//use yii\console\ErrorHandler;
use yii\db\IntegrityException;

class ParcelController extends Controller
{
	public $table_name = 'parcel';
    public function actionEdit()
    {
        return ExitCode::OK;
    }

    public function actionIndex()
    {
        return ExitCode::OK;
    }

	public function actionGetAll() {//parcel/get-all
		$parcels = Parcel::find()
			->indexBy('id')
			->all();
//		Yii::info(VarDumper::dumpAsString($photos));
		foreach ($parcels as $parcel){
			$id = $this->ansiFormat($parcel['id'], Console::FG_YELLOW);
			$product_id = $this->ansiFormat($parcel['product_id'], Console::FG_YELLOW);
			$code = $this->ansiFormat($parcel['code'], Console::FG_YELLOW);
			$height = $this->ansiFormat($parcel['height'], Console::FG_YELLOW);
			$width = $this->ansiFormat($parcel['width'], Console::FG_YELLOW);
			$depth = $this->ansiFormat($parcel['depth'], Console::FG_YELLOW);
			echo "photo_id ".$id." product_id ".$product_id.' code '.$code.' height '.$height."\n";
		}
		return ExitCode::OK;
	}
	public function actionAddOne($id=1){//parcel/add-one <product_id>
		$product = Product::findOne($id);
		if($product == NULL){
			echo "not product found $id\n";
			return ExitCode::OK;
		}	
		if($id){
			try{
				$parcel = new Parcel();
				$parcel->product_id = $id;
				$parcel->code = 'dd';
				$parcel->height = 1;
				$parcel->width = 1;
				$parcel->depth = 1;
				if ($parcel->validate()) {
					$parcel->save();
					echo "photo add $parcel->id\n";
				} else {				
					$errors = $parcel->errors;
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

}
