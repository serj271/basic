<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\common\components\CurlGetHelpers;
use app\common\components\CurlHelper;
use app\common\components\HelloHelpers;
use yii\httpclient\Client;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Exception;
use yii\helpers\Console;
use Yii;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use app\models\User;
use app\common\components\CurlAuthHelpers;
use yii\helpers\BaseUrl;

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
	
	public function actionGetAll()
	{
        try {
            $users = $users = \Yii::$app->db
                ->createCommand('SELECT * FROM user;')
                ->queryAll();
        } catch (Exception $e) {
            Yii::info(VarDumper::dumpAsString($e));
            $message_error = 'error';
//				echo $e->getCode();
//				echo $e->getMessage()."\n";
            if (isset($e->errorInfo[2])) {
                $message_error = $this->ansiFormat($e->errorInfo[2], Console::BOLD);
            }
            echo $message_error."\n";
            return ExitCode::OK;
        }
//		Yii::info(VarDumper::dumpAsString($users));
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
	
	public function actionCreate($username,$password='1')
	{
        try {
            \Yii::$app->db
                ->createCommand()
                ->insert('user', [
                    'email' => $username . '@example.com',
                    'password_hash' => Yii::$app->security->generatePasswordHash($password),
                    'password_reset_token' => 'e',
                    'status' => '1',
                    /* 	'role'=>'1', */
                    'username' => $username,
                    'auth_key' => '',
                    'created_at' => time(),
                    'updated_at' => time()
                ])
                ->execute();
        } catch (\yii\base\Exception $e) {
            Yii::info(VarDumper::dumpAsString($e));
            $message_error = 'error';
//				echo $e->getCode();
//				echo $e->getMessage()."\n";
            if (isset($e->errorInfo[2])) {
                $message_error = $this->ansiFormat($e->errorInfo[2], Console::BOLD);
            }
            echo $message_error."\n";
        }
        return ExitCode::OK;
	}
	public function actionAddOne($username)
	{
		$user = new User();
//		$user->id = 12;
//		$user->type = 'public';
		$user->username = $username;
		$user->email = $username.'@example.com';
		$user->setPassword('1');
        $user->generateAuthKey();
		$user->password_reset_token = '11';
        $user->auth_key = \Yii::$app->security->generateRandomString();
        Yii::info(VarDumper::dumpAsString($user));
		if ($user->validate()) {
			$user->save();

			echo "user add \n";
		} else {
			$errors = $user->errors;
			foreach($errors as $key=>$value){
				echo "$key => $value[0]\n";
			}			
		}
	}	
	public function actionDetail($id)
	{
		$user = \Yii::$app->db
			->createCommand("SELECT * FROM user where id=:id")
			->bindValue(':id', $id)
			->queryOne();
		echo VarDumper::dumpAsString($user)."\n";
		Yii::info(VarDumper::dumpAsString($user));
		$userRoles = Yii::$app->authManager->getRolesByUser($id);
		
		$userNameRoles = [];
		foreach($userRoles as $role){
				echo 'role '.$role->name."\n";
				$userNameRoles[] = $role->name;
		}
		$authRoles = Yii::$app->authmanager->getRoles();
		$nameRoles = [];
//		$roles2 = Yii::$app->db->createCommand('select * from auth_item')->queryAll();
//		var_dump($roles);
		foreach($authRoles as $key=>$value){
			$nameRoles[$key] = $value->name;
		}
//		var_dump($roles2);
		var_dump($userNameRoles);
		return ExitCode::OK;
	}
	public function actionDelete($id)
	{
		$user =  \Yii::$app->db
			->createCommand()
			->delete('user','id=:id',[':id'=>$id])//table condition params
			->execute();
		Yii::info(VarDumper::dumpAsString($user));//0 or 1		
		echo VarDumper::dumpAsString($user);
		return ExitCode::OK;
	}
	public function actionLogin($id, $password='1')
	{
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
	public function actionUpdate($id)
	{
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
	public function actionDeleteRoleAdmin($id)
	{
		$auth = Yii::$app->authManager;
		$item = $auth->getRole('admin'); // 
		$auth->revoke($item,$id);
		
		return ExitCode::OK;
	}
	public function actionAddRoleAdmin($id)
	{
		$auth = Yii::$app->authManager;
		$editor = $auth->getRole('admin'); // 
		$auth->assign($editor, $id);
		$auth = Yii::$app->authManager;
		$login = $auth->getRole('guest'); // 
		$auth->assign($login, $id);
		return ExitCode::OK;
	}
//	public function actionCurlGetAll()
//	{
//		$uri = Yii::$app->urlManager->createUrl(['json','controller'=>'json-user', 'action'=>'index']);
		//$url = 'http://192.168.1.1'.$uri;
		/*$user = User::findByUsername('test');
		$auth_token = $user->getAuthKey();
 		Yii::info(VarDumper::dumpAsString('$auth_token'));
		Yii::info(VarDumper::dumpAsString($auth_token));
		list($users, $getinfo) = CurlAuthHelpers::get($url,$auth_token);
		if($getinfo['http_code'] != 200)
		{
			echo "code {$getinfo['http_code']}\n";
			return ExitCode::OK;
		}	*/
	//	echo VarDumper::dumpAsString($users);
		/* if(count($users) !== 0){
			foreach ($products as $product){
				foreach($product as $key => $value){
					echo "$key => ".$this->ansiFormat($value, Console::FG_YELLOW)."\n";
				}
			}
		} */
//		echo $data;
//		echo Yii::$app->urlManager->createUrl(['json','controller'=>'json-product', 'action'=>'index'])."\n"; 
//		return ExitCode::OK;
//	}
	
	public function actionCurlHello()
    {
        $uri = Yii::$app->urlManager->createUrl(['json','controller'=>'hello', 'action'=>'index']);
        $url = Yii::$app->params['server'].$uri;
        $hello = CurlGetHelpers::get($url);
  //      Yii::info(VarDumper::dumpAsString($hello));
        echo $hello;
        return ExitCode::OK;
    }
    public function actionCurlGetAll()
    {
        $uri = Yii::$app->urlManager->createUrl(['json','controller'=>'user', 'action'=>'get-all']);
        $url = Yii::$app->params['server'].$uri;
        $hello = CurlHelper::getAll($url);
        //      Yii::info(VarDumper::dumpAsString($hello));
        echo $hello;
        return ExitCode::OK;
    }
    public function actionCurlGetOne()
    {
        $uri = Yii::$app->urlManager->createUrl(['json','controller'=>'user',
            'action'=>'get-one'
        ]);
   //     echo Yii::$app->security->maskToken('input');
   //     echo \yii\web\Request::getCsrfToken;
        $url = Yii::$app->params['server'].$uri;
        $hello = CurlHelper::getOne($url,1);
        //      Yii::info(VarDumper::dumpAsString($hello));
        echo $hello;
        return ExitCode::OK;
    }
	public function actionClientGetOne()
    {
        $uri = Yii::$app->urlManager->createUrl(['json','controller'=>'user',
            'action'=>'get-one'
        ]);
        $url = Yii::$app->params['server'].$uri;
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl($url)
            ->setData(['id' => 1])
            ->send();
        if ($response->isOk) {
            $newUserId = $response->data['id'];
          //  echo $response->getHeaders()->get('content-type');
            echo $newUserId."\n";
            Yii::info(VarDumper::dumpAsString($response->data));
        }

        return ExitCode::OK;
    }
}
//./yii hello user/index --message="hello all"