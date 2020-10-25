<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use Yii;
use yii\base;
use yii\db\Query;
use yii\helpers\VarDumper; 
use app\models\Customer;
use yii\db\ActiveRecord;
//use yii\console\ErrorHandler;
use yii\db\IntegrityException; 

class CustomerController extends Controller
{
	public $table_name = 'customer';
	
    
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
	public function actionGetAll() 
	{//reservation/get-all		
		$model = new Customer();
		$items = Customer::find()	
			->indexBy('id')
			->all();
		$attributes = $model->getAttributes();
//		Yii::info(VarDumper::dumpAsString($model->attributeTypes));		
//		Yii::info(VarDumper::dumpAsString($model->getActiveValidators()));//rules()
		$message = '';
		if(count($items) !== 0){
			foreach ($items as $p){
				foreach(array_keys($attributes) as $key){
					echo "$key => ".$this->ansiFormat($p[$key], Console::FG_YELLOW).".\n";
				}	
			}
		}
//		Yii::info(VarDumper::dumpAsString(\Yii::$app->params['thumbnail.size']));//from params config
		return ExitCode::OK;
	}
	public function actionAddOne($id,$phone_number){//product-photo/add-one <product_id>
//		$product = Reservation::findOne($id);		
			try{
				$item = new Customer();
//				$attributes = array_keys($photo->getAttributes());
				$item->id = $id;
				$item['name'] = 'name'.$id;
				$item->surname = 'surname'.$id;
				$item->phone_number = 'phone_number'.$phone_number;
				
				if ($item->validate()) {
					$last_id = $item->save();
					echo "item add $item->id $last_id\n";
				} else {				
					$errors = $item->errors;
					foreach($errors as $key=>$value){
						echo "$key=>$value[0]\n";
					}

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
				$model = Customer::findOne($id);
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
    
	public function actionGetOne($id){
		$item = Customer::findOne($id);	
		if($item == NULL){
			echo "not found item id $id\n";
			return ExitCode::OK;
		}
		$model = new Customer();
		$attributes = $model->getAttributes();
		foreach(array_keys($attributes) as $key){
			echo "$key => ".$this->ansiFormat($item[$key], Console::FG_YELLOW).".\n";
		}
//		Yii::info(VarDumper::dumpAsString($model->attributeTypes));		
//		Yii::info(VarDumper::dumpAsString($model->getActiveValidators()));//rules()
		return ExitCode::OK;
	}

}
