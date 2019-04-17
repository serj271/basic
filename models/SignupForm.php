<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\helpers\VarDumper;
/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SignupForm extends Model
{
    public $username;
    public $password;
	public $email;
    public $rememberMe = true;
	public $user;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
//			['username', 'unique'],
//            ['username', 'unique', 'targetClass' => UserModel::class, 'message' => Yii::t('yii2mod.user', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
//			['email', 'unique'],
 //           ['email', 'unique', 'targetClass' => UserModel::class, 'message' => Yii::t('yii2mod.user', 'This email address has already been taken.')],
            ['password', 'required'],
            ['password', 'string', 'min' => 2],
        ];
    }

    public function signup()
    {
//		Yii::info(VarDumper::export($this->attributes));
        if (!$this->validate()) {
            return null;
        }
        $this->user = new User;
        $this->user->setAttributes($this->attributes);
        $this->user->setPassword($this->password);
//		$this->user->pass = '33';
		
 //       $this->user->setLastLogin(time());
        $this->user->generateAuthKey();
//		Yii::info(VarDumper::dumpAsString(array('q'=>4))); 
//		Yii::info(VarDumper::dumpAsString('$this->user->password_hash'.$this->user->password_hash));
//		Yii::info(VarDumper::dump($this->user));
        return $this->user->save(false) ? $this->user : null;
    }
    /**
     * @return UserModel|null
     */
    public function getUser()
    {
        return $this->user;
    }
}
