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
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;


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
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
   /*  public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    } */
	public $message='default message';
    
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
        echo $this->message . "\n";
//		Yii::info('message log');
//		Yii::info(VarDumper::dumpAsString(array('q'=>4)));
//		Yii::debug('start calculating average revenue');
//		 $this->stdout("whatever");
///		$name = $this->ansiFormat('Alexander', Console::FG_YELLOW);
//		echo "Hello, my name is $name.";
		return ExitCode::OK;
    }
	
	public function actionGetAll(){
		$users = $users = \Yii::$app->db
			->createCommand('SELECT * FROM user;')
			->queryAll();
		Yii::info(VarDumper::dumpAsString($users));
		$count = \Yii::$app->db
			->createCommand('SELECT COUNT(*) FROM user')
			->queryScalar();
		echo "$count\n";
//		echo $users[0]['email']."\n";
		echo VarDumper::dumpAsString($users);
		$user = \Yii::$app->db
			->createCommand('SELECT email FROM user')
			->queryColumn();
		$result = \Yii::$app->db
			->createCommand("SELECT COUNT([[id]]) FROM {{user}}")
			->queryScalar();
		return ExitCode::OK;
	}
	
	public function actionCreate($username,$password='1'){
		\Yii::$app->db
		->createCommand()
		->insert('user', [
		'email' => $username.'@example.com',
		'password_hash' => Yii::$app->security->generatePasswordHash($password),
		'password_reset_token'=>'e',
		'status'=>'1',
		'role'=>'1',
		'username' => $username,
		'auth_key'=>'',
		'created_at' => time(),
		'updated_at' => time()
		])
		->execute();
		return ExitCode::OK;
	}
	public function actionDetail($id){
		$user = \Yii::$app->db
			->createCommand("SELECT * FROM user where id=:id")
			->bindValue(':id', $id)
			->queryOne();
		Yii::info(VarDumper::dumpAsString($user));
		$rolesUser = Yii::$app->authManager->getRolesByUser($id);
		echo VarDumper::dumpAsString($user)."\n";
		foreach($rolesUser as $role){
				echo 'role '.$role->name."\n";
		}
		$roles = Yii::$app->authmanager->getRoles();
		$roles3 = [];
//		$roles2 = Yii::$app->db->createCommand('select * from auth_item')->queryAll();
//		var_dump($roles);
		foreach($roles as $key=>$value){
			$roles3[$key] = $value->name;
		}
//		var_dump($roles2);
		var_dump($roles3);
	}
	public function actionDelete($id){
		$user =  \Yii::$app->db
			->createCommand()
			->delete('user','id=:id',[':id'=>$id])//table condition params
			->execute();
		Yii::info(VarDumper::dumpAsString($user));//0 or 1		
		echo VarDumper::dumpAsString($user);
		return ExitCode::OK;
	}
	public function actionLogin($id, $password='1'){
		$user = \Yii::$app->db
			->createCommand("SELECT * FROM user where id=:id")
			->bindValue(':id', $id)
			->queryOne();
		if($user == null){
			echo "user not found";
		} else {
			echo VarDumper::dumpAsString($user['username']);
			$validatePassword= Yii::$app->security->validatePassword($password, $user['password_hash']);
			echo VarDumper::dumpAsString($validatePassword)."\n";
		}
		
		return ExitCode::OK;
	}
	public function actionUpdate($id){
		if (!\Yii::$app->user->can('updateOwnProfile', ['profileId' => \Yii::$app->user->id])) {
			throw new ForbiddenHttpException('Access denied');
		}
		/* 
		$user =  \Yii::$app->db
			->createCommand()
			->delete('user','id=:id',[':id'=>$id])//table condition params
			->execute();
		Yii::info(VarDumper::dumpAsString($user));//0 or 1		
		echo VarDumper::dumpAsString($user); */
		return ExitCode::OK;
	}
	public function actionDeleteRoleAdmin($id){
		$auth = Yii::$app->authManager;
		$item = $auth->getRole('admin'); // 
		$auth->revoke($item,$id);
		
		return ExitCode::OK;
	}
	public function actionAddRoleAdmin($id){
		$auth = Yii::$app->authManager;
		$editor = $auth->getRole('admin'); // 
		$auth->assign($editor, $id);
		$auth = Yii::$app->authManager;
		$login = $auth->getRole('guest'); // 
		$auth->assign($login, $id);
		return ExitCode::OK;
	}
	
	
}
//./yii hello user/index --message="hello all"