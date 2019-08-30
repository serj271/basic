<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use yii\console\Exception;
use yii\helpers\ArrayHelper;
use app\models\User;
use yii\helpers\VarDumper;

class RolesController extends Controller
{
	public function actionGetRole()
    {
        $username = $this->prompt('Username:', ['required' => true]);
        $user = $this->findModel($username);
		$auth = Yii::$app->authManager;
		$rolesAvailable = $auth->getRoles();
		$rolesNamesByUser = [];
		// For each user, fill $rolesNames with name of roles assigned to user
//		foreach($users as $user)
//		{
			$rolesNames = [];
			$roles = $auth->getRolesByUser($user->id);
			foreach($roles as $r)
			{
				$rolesNames[] = $r->name;
			} 
//			$rolesNamesByUser[$user->id] = $rolesNames;
//		}
//        $roleName = $this->select('Role:', ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'));
//		Yii::info(VarDumper::dumpAsString($rolesNamesByUser)); 
		foreach($rolesNames as $key=>$value){
			echo $this->ansiFormat($value, Console::FG_YELLOW).".\n";
		} 
//        $authManager = Yii::$app->getAuthManager();
//        $role = $authManager->getRole($roleName);
        
//        $authManager->assign($role, $user->id);
		/* $userId = Yii::$app->user->id; //id current user
		$userRole = Yii::$app->authManager->getRole('admin');
		Yii::$app->authManager->assign($userRole, $userId); */

        $this->stdout('Done!' . PHP_EOL);
    }

    public function actionAssign()
    {
        $username = $this->prompt('Username:', ['required' => true]);
        $user = $this->findModel($username);
        $roleName = $this->select('Role:', ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'));

        $authManager = Yii::$app->getAuthManager();
        $role = $authManager->getRole($roleName);
        if($authManager->getAssignment($roleName, $user->id)){
			echo 'user '.$user->id.' already has role '."\n";
		} else {
			$authManager->assign($role, $user->id);
		}
        
		/* $userId = Yii::$app->user->id; //id current user
		$userRole = Yii::$app->authManager->getRole('admin');
		Yii::$app->authManager->assign($userRole, $userId); */

        $this->stdout('Done!' . PHP_EOL);
    }


    public function actionRevoke()
    {
        $username = $this->prompt('Username:', ['required' => true]);
        $user = $this->findModel($username);
        $roleName = $this->select('Role:', ArrayHelper::merge(
            ['all' => 'All Roles'],
            ArrayHelper::map(Yii::$app->authManager->getRolesByUser($user->id), 'name', 'description'))
        );
        $authManager = Yii::$app->getAuthManager();

        if ($roleName == 'all') {
            $authManager->revokeAll($user->id);
        } else {
            $role = $authManager->getRole($roleName);
            $authManager->revoke($role, $user->id);
        }
        $this->stdout('Done!' . PHP_EOL);
    }


    private function findModel($username)
    {
        if (!$model = User::findOne(['username' => $username])) {
            throw new Exception('User is not found');
        }
        return $model;
    }
}