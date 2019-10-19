<?php

namespace tests\models;

use app\models\User;
use PHPUnit\DbUnit\TestCaseTrait;

class UserTest extends \Codeception\Test\Unit
{
	public $user;
	/* public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__).'/_files/guestbook-seed.xml');
    } */
	/* use TestCaseTrait;
	public function getDataSet()
	{
	$ds = $this->createFlatXmlDataSet('myFlatXmlFixture.xml');
	$rds = new PHPUnit_Extensions_Database_DataSet_ReplacementDataSet($ds);
	$rds->addFullReplacement('##NULL##', null);
	return $rds;
	} */
	protected function _before(){
		
	}
	
	function testSavingUser()
	{
		$user = new User();
		$user->id = 1;
		$user->type = 'admin';		
		$user->username = 'admin';
		$user->email = 'admin@example.com';
		$user->setPassword('1');
        $user->generateAuthKey();
		$user->password_reset_token = '11';
		$this->user = $user->save();
//		fwrite(STDOUT, __METHOD__.$this->user . "\n");
		$this->assertEquals('admin', $user->getUsername());
//		$this->unitTester->seeInDatabase('users',array('name' => 'Miles', 'surname' => 'Davis'));
	}
	
	function testNotUniqueUser()
	{
		$user = new User();
//		$user->id = 12;
		$user->type = 'admin';		
		$user->username = 'user';
		$user->email = 'user@example.com';
		$user->setPassword('1');
        $user->generateAuthKey();
		$user->password_reset_token = '11';
	/* 	$this->assertFalse($this->user_id = $user->save()); */
		$this->assertEquals('user', $user->getUsername());
		$user = new User();
//		$user->id = 12;
		$user->type = 'admin';		
		$user->username = 'user';
		$user->email = 'user@example.com';
		$user->setPassword('1');
        $user->generateAuthKey();
		$user->password_reset_token = '11';
		if ($user->validate()) {
			$this->user = $user->save();
		} else {				
			$errors = $user->errors;
			$this->assertNotEmpty($errors['username']);

			/* foreach($errors as $key=>$value){
				echo "$key => $value[0]\n";
			}	 */		
		}	
//		$this->assertEquals('user', $user->getUsername());
//		$this->unitTester->seeInDatabase('users',array('name' => 'Miles', 'surname' => 'Davis'));
	}
	
    public function testFindUserById()
    {
//		fwrite(STDOUT, __METHOD__.$this->user . "\n");
        expect_that($user = User::findIdentity(1));
        expect($user->username)->equals('admin');

        expect_not(User::findIdentity(999));
    }

   /*  public function testFindUserByAccessToken()
    {
        expect_that($user = User::findIdentityByAccessToken('100-token'));
        expect($user->username)->equals('admin');

        expect_not(User::findIdentityByAccessToken('non-existing'));        
    } */

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('admin'));
        expect_not(User::findByUsername('not-admin'));
    }
	public function testDeleteUsers()
	{
		$users = User::find()->all();
		foreach($users as $user)
		{
			$username = $user->username;
			$user->delete();
			expect_not(User::findByUsername($username));
		}
		
	}
    /**
     * @depends testFindUserByUsername
     */
   /*  public function testValidateUser($user)
    {
        $user = User::findByUsername('admin');
        expect_that($user->validateAuthKey('test100key'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('admin'));
        expect_not($user->validatePassword('123456'));        
    } */
	
    

}
