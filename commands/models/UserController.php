<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands\models;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use app\models\User;
use Yii;
use yii\base;
use yii\helpers\VarDumper;
use yii\base\InvalidValueException;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UserController extends Controller
{
	public $message='default message';
	public $passCompare;
    
    public function options($actionID)
    {
        return ['message'];
    }
    
    public function optionAliases()
    {
        return ['m' => 'message'];
    }
    
    public function actionIndex()
    {
        /* echo $this->message . "\n";
		Yii::info('message log');
		Yii::info(VarDumper::dumpAsString(array('q'=>4)));
		Yii::debug('start calculating average revenue');

		$name = $this->ansiFormat('Alex', Console::FG_YELLOW); */
		echo "Hello, models user.\n";
		
		
		
		
		return ExitCode::OK;
    }
	
	public function actionCreate($username){
		$user = new User;
		$user->loadDefaultValues();
		$user->username = $username;
		$user->email = $username.'@example.com';
		$user->pass = '11';
		$user->auth_key = '00';
//		$user->password_hash = '117';
//		$user->setAttribute('password_hash','ee');
		Yii::info(VarDumper::dump($user));
		Yii::info(VarDumper::dump($user->getDirtyAttributes()));
//		$user->type = 'author';
//		$user->date_entered = 
		if ($user->validate()){
			$user->save();
		} else {
			$errors = $user->errors;
			Yii::info(VarDumper::dumpAsString($errors));
			var_dump($errors);
			$exception = Yii::$app->errorHandler->exception;
			var_dump($exception);
		}	
		
	}
	
	public function actionGetAll(){//User::findAll([1, 2, 3, 4]);
//		$model = new User;
		$users = User::find()->asArray()
			->all();
		var_dump($users);
	}
	public function actionGetOne($id){
		$user = User::findOne($id);
		echo "$user->email\n";
//		var_dump($user);
	}
	public function actionDelete($id){
		$user = User::findOne($id);
		if(empty($user)){
			echo "not found model id ".$id."\n";
		} else {
			$user->delete();
			echo "deleted $user->username\n";
		}		
	}
	public function actionGetUsername($username){//User::findOne(['role_id' => 2,'last_name' => 'Doe']);
	//$users = User::find()->orderBy('id'])->all();
		$users = User::findAll([
		'username' => $username
		]);
		var_dump($users);
	}
	public function actionGetCurrentUser(){
		$user = User::findOne(1);
		Yii::$app->user->login($user);
		var_dump(Yii::$app->user);
//		Yii::$app->set('request', new \yii\web\Request());
		echo Yii::$app->user->id;
	}
	public function actionSetCurrentUser(){
		$user = User::findOne(5);
		Yii::$app->set('request', new \yii\web\Request());
		Yii::$app->user->setIdentity($user);
		
	}
	
	
}

/* $session = \Yii::$app->session->set('name', 'ASG');
    if(\Yii::$app->session) // to check session works or not
        echo \Yii::$app->session->get('name')."\n";
    print_R(\Yii::$app->user); */