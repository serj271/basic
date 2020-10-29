<?php

namespace app\commands;
use Yii;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use \app\rbac\UserGroupRule;
use \app\rbac\UserProfileOwnerRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = \Yii::$app->authManager;
 
        // Create roles
        $guest  = $authManager->createRole('guest');
        $brand  = $authManager->createRole('BRAND');
        $talent = $authManager->createRole('TALENT');
        $admin  = $authManager->createRole('admin');
 
        // Create simple, based on action{$NAME} permissions
        $login  = $authManager->createPermission('login');
        $logout = $authManager->createPermission('logout');
        $error  = $authManager->createPermission('error');
        $signUp = $authManager->createPermission('sign-up');
        $index  = $authManager->createPermission('index');
        $view   = $authManager->createPermission('view');
        $update = $authManager->createPermission('update');
        $delete = $authManager->createPermission('delete');
 
        // Add permissions in Yii::$app->authManager
        $authManager->add($login);
        $authManager->add($logout);
        $authManager->add($error);
        $authManager->add($signUp);
        $authManager->add($index);
        $authManager->add($view);
        $authManager->add($update);
        $authManager->add($delete);
 
 
        // Add rule, based on UserExt->group === $user->group
        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);
 
        // Add rule "UserGroupRule" in roles
        $guest->ruleName  = $userGroupRule->name;
        $brand->ruleName  = $userGroupRule->name;
        $talent->ruleName = $userGroupRule->name;
        $admin->ruleName  = $userGroupRule->name;
 
        // Add roles in Yii::$app->authManager
        $authManager->add($guest);
        $authManager->add($brand);
        $authManager->add($talent);
        $authManager->add($admin);
 
        // Add permission-per-role in Yii::$app->authManager
        // Guest
        $authManager->addChild($guest, $login);
        $authManager->addChild($guest, $logout);
        $authManager->addChild($guest, $error);
        $authManager->addChild($guest, $signUp);
        $authManager->addChild($guest, $index);
        $authManager->addChild($guest, $view);
 
        // BRAND
        $authManager->addChild($brand, $update);
        $authManager->addChild($brand, $guest);
 
        // TALENT
        $authManager->addChild($talent, $update);
        $authManager->addChild($talent, $guest);
 
        // Admin
        $authManager->addChild($admin, $delete);
        $authManager->addChild($admin, $talent);
        $authManager->addChild($admin, $brand);
    
    }
	public function actionAddUserProfile(){
		$userGroupRule = new UserGroupRule();
	/*	$brand->ruleName  = $userGroupRule->name;
        $talent->ruleName = $userGroupRule->name;*/
		$authManager = \Yii::$app->authManager;
		$userProfileOwnerRule = new UserProfileOwnerRule();
		$authManager->add($userProfileOwnerRule);
		 
		$updateOwnProfile = $authManager->createPermission('updateOwnProfile');
		$updateOwnProfile->ruleName = $userProfileOwnerRule->name;
		$authManager->add($updateOwnProfile);
		 
		/*$authManager->addChild($brand, $updateOwnProfile);
		$authManager->addChild($talent, $updateOwnProfile);*/
	}
	public function actionDeleteAllRoles(){
        $authManager = \Yii::$app->authManager;
 //       $this->db = $authManager->db;

        /* $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable); */
		$authManager->removeAll();
		
		return ExitCode::OK;
	}
}