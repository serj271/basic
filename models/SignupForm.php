<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use app\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\IntegrityException;
use yii\db\Expression;
use yii\behaviors\AttributeTypecastBehavior; 
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
	public $status;
	public $id;
	public $created_at;
	public $updated_at;
	public $role;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
 //           ['username', 'unique', 'targetClass' => UserModel::class, 'message' => Yii::t('yii2mod.user', 'This username has already been taken.')],
			['username', 'unique', 'targetClass' => '\app\models\User','message' => 'This username has already been taken.'],
			['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 1],
			['status', 'required'],
            ['status',  'integer', 'min' => 0],
 //          	['role', 'required'],
        ];
    }
	public function behaviors()
	{
		return [
			/* 'timestamp' => [
				'class' => 'yii\behaviors\TimestampBehavior',
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
				'value' => new Expression('NOW()'),
			], */
			/* 'typecast' => [
                'class' => AttributeTypecastBehavior::className(),
                'attributeTypes' => [
                    'id' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'status' => AttributeTypecastBehavior::TYPE_INTEGER,//TYPE_STRING FLOAT
                ],
 //               'typecastAfterValidate' => true,
 //               'typecastBeforeSave' => false,
  //              'typecastAfterFind' => false,
            ], */
		];
	} 

    public function signup()
    {
//		Yii::info(VarDumper::export($this->attributes));
//        if (!$this->validate()) {
 //           return null;
 //       }
		$this->user = new User;
        $this->user->setAttributes($this->attributes);
        $this->user->setPassword($this->password);
		$this->user->setPasswordResetToken();
		$this->user->validate();
		
		$this->user->generateAuthKey();
//		Yii::info(VarDumper::dumpAsString(array('q'=>4))); 
//		Yii::info(VarDumper::dumpAsString('$this->user->password_hash'.$this->user->password_hash));
//		Yii::info(VarDumper::dump($this->user));
		$this->user->save();
		return $this->user;
    }
    /**
     * @return UserModel|null
     */
    public function getUser()
    {
		$auth = Yii::$app->authManager;

        $auth->removeAll();
        return $this->user;
    }
}
