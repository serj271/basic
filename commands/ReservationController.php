<?php

namespace app\commands;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use Yii;
use yii\base;
use yii\db\Query;
use yii\helpers\VarDumper; 
use app\models\Reservation;
use yii\db\ActiveRecord;
//use yii\console\ErrorHandler;
use yii\db\IntegrityException; 


class ReservationController extends Controller
{
	public $table_name = 'reservation';
	public $enableCsrfValidation = false;
   /*  public function actionIndex()
    {
        return ExitCode::OK;
    }
	protected function beforeRun()
    {
        $this->controller->enableCsrfValidation = false;
        return parent::beforeRun();
    }
 */
/* 
    public function run()
    {
        var_dump(\Yii::$app->controller->enableCsrfValidation);
        return '123';
    } */	
	
	public function actionGetAll() 
	{//reservation/get-all
		
		$model = new Reservation();
		$reservations = Reservation::find()	
			->indexBy('id')
			->all();
		$attributes = $model->getAttributes();
//		Yii::info(VarDumper::dumpAsString(Yii::$app->controller->module->id));//basci-console 
//		Yii::info(VarDumper::dumpAsString($model->attributeTypes));		
//		Yii::info(VarDumper::dumpAsString($model->getActiveValidators()));//rules()
		$message = '';
		if(count($reservations) !== 0){
			foreach ($reservations as $p){
				foreach(array_keys($attributes) as $key){
					echo "$key => ".$this->ansiFormat($p[$key], Console::FG_YELLOW).".\n";
				}	
			}
		}
//		Yii::info(VarDumper::dumpAsString(\Yii::$app->params['thumbnail.size']));//from params config
		return ExitCode::OK;
	}
	public function actionAddOne($room_id=1,$customer_id=1,$date_from,$date_to)
	{
//		$product = Reservation::findOne($id);		
			try{
				$item = new Reservation();
//				$attributes = array_keys($photo->getAttributes());
				
				$item['room_id'] = $room_id;
				$item->customer_id = $customer_id;
				$item->price_per_day = 0.20;
				$item->date_from = $date_from;
				$item->date_to = $date_to;
				
				if ($item->validate()) {
					$last_id = $item->save();
					echo "item add $item->id $last_id\n";
				} else {				
					$errors = $item->errors;
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
	
	public function actionDeleteOne($id=1)
	{
			try{
				$model = Reservation::findOne($id);
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
		$item = Reservation::findOne($id);	
		if($item == NULL){
			echo "not found item id $id\n";
			return ExitCode::OK;
		}
		$model = new Reservation();
		$attributes = $model->getAttributes();
		foreach(array_keys($attributes) as $key){
			echo "$key => ".$this->ansiFormat($item[$key], Console::FG_YELLOW).".\n";
		}
//		Yii::info(VarDumper::dumpAsString($model->attributeTypes));		
//		Yii::info(VarDumper::dumpAsString($model->getActiveValidators()));//rules()
		return ExitCode::OK;
	} 

}
