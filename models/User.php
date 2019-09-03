<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use app\components\MyBehavior;
//use yii2mod\user\models\enums\UserStatus;
//use yii2mod\user\traits\EventTrait;
/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $pass
 * @property string $type
 * @property string $date_entered
 *
 * @property Comment[] $comments
 * @property File[] $files
 * @property Page[] $pages
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * Event is triggered before creating a user.
     * Triggered with \yii2mod\user\events\CreateUserEvent.
     */
    const BEFORE_CREATE = 'beforeCreate';
    /**
     * Event is triggered after creating a user.
     * Triggered with \yii2mod\user\events\CreateUserEvent.
     */
    const AFTER_CREATE = 'afterCreate';
	const STATUS_ACTIVE = 1;
    /**
     * @var string plain password
     */

	public $password_hash;
	public $type;
	public $group;
//	public $pass;
	
    public static function tableName()
    {
        return 'user';
    }
	public function scenarios() {
		return [
			'login' => ['username', 'pass'],
			'register' => ['username', 'email', 'pass']
		];
	}
	public function beforeSave($insert) {
	// Do whatever.
		return parent::beforeSave($insert);
	}
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'required', 'message' => 'Please choose a username.'],
////			[['type'], 'safe'],
			['type', 'in', 'range' => ['public','author','admin']],
            [['created_at'], 'safe'],
			[['password_reset_token', 'auth_key', 'password_hash'], 'string', 'max' => 80],
            [['username'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 60],
//            [['pass'], 'string', 'max' => 64],
//			[['pass'], 'string', 'length' => [2,20] ],
            [['username'], 'unique'],
            [['email'], 'unique'],
			['status', 'default', 'value' => self::STATUS_ACTIVE],
/* 			['attr', 'filter', 'filter' => function($v) {
			// Do whatever to $v.
				return $v;
			}] */
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'E-mail',
 //           'pass' => 'Pass',
            'status' => 'status',
            'created_at' => 'Date created_at',
        ];
    }
	/* public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)){
		   $this->password_hash=$this->setPassword($this->pass);
		   return true;
		}else{
		   return false;
		}
	} */
	public function fields()
	{
		$fields = parent::fields();
		// 
		unset($fields[’auth_key’], $fields[’password_hash’], $fields[’password_reset_token’]);
		return $fields;
	}

	public function behaviors()
	{
		return [
			MyBehavior::className(),
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
//					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
				'value' => new Expression('NOW()'),
			],
			TimestampBehavior::className(),
						
		];
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['user_id' => 'id']);
    }
	/* public function validatePassword($attribute, $params) {
		if (!$this->hasErrors()) {
			$user = $this->getUser();
			if (!$user || !$user->validatePassword($this->password)) {
				$this->addError($attribute, 'Incorrect username or
			password.');
			}
		}
	} */
	public function create()
    {
            $this->setPassword($this->plainPassword);
            $this->generateAuthKey();
            if (!$this->save()) {
                $transaction->rollBack();
                return null;
            }
          
            return $this;
        /*  catch (\Exception $e) {
            $transaction->rollBack();
            Yii::warning($e->getMessage());
            throw $e;
        } */
    }
	public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
	{
	return static::findOne(['auth_key' => $token]);
	}
    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    /**
     * Finds user (with active status) by username
     *
     * @param  string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    /**
     * Finds user by email
     *
     * @param $email
     *
     * @return null|static
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
	{
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		$parts = explode('_', $token);
		$timestamp = (int) end($parts);
		if ($timestamp + $expire < time()) {
		// token expired
			return null;
		}
		return static::findOne([
			'password_reset_token' => $token,
			'status_id' => self::STATUS_ACTIVE,
		]);
	}
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     *
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = ArrayHelper::getValue(Yii::$app->params, 'user.passwordResetTokenExpire', 3600);
        return $timestamp + $expire >= time();
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    /**
     * Validates password
     *
     * @param  string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)//validatePassword($attribute, $params)
    {
		/* if (!$this->hasErrors()) {
			$user = $this->getUser();
		if (!$user || !$user->validatePassword($this->password)) {
			$this->addError($attribute, 'Incorrect username or password.');
			}
		} */
//		Yii::info(VarDumper::export($this->getAttributes()));
//		Yii::info(VarDumper::export($this->getOldAttributes()),'----------------------------------', $password);
//		Yii::info('pass'.'-----------'.$password);
        return Yii::$app->security->validatePassword($password, $this->getOldAttributes()['password_hash']);
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
 //       $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
		$this->setAttribute('password_hash',Yii::$app->getSecurity()->generatePasswordHash($password));
    }
	public function setPasswordResetToken()
    {
 //       $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
		$this->setAttribute('password_reset_token',Yii::$app->getSecurity()->generateRandomString());
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
    }
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
    }
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /**
     * @param $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->last_login = $lastLogin;
    }
    /**
     * Update last login
     */
    public function updateLastLogin()
    {
        $this->updateAttributes(['last_login' => time()]);
    }
    /**
     * Resets password.
     *
     * @param string $password
     *
     * @return bool
     */
    public function resetPassword($password)
    {
        $this->setPassword($password);
        return $this->save(true, ['password_hash']);
    }
	
}
