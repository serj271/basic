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
//use yii2mod\user\models\enums\UserStatus;
//use yii2mod\user\traits\EventTrait; 
use yii\base\Model;
use app\models\CommentModel;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $page_id
 * @property string $comment
 * @property string $date_entered
 *
 * @property Page $page
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
	public $user_id;
	public $page_id;
	public $comment;
	public $date_entered;
	
    public function rules()
    {
        return [
            [['user_id', 'page_id', 'comment'], 'required'],
            [['user_id', 'page_id'], 'integer'],
            [['comment'], 'string'],
            [['date_entered'], 'safe'],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'page_id' => 'Page ID',
            'comment' => 'Comment',
            'date_entered' => 'Date Entered',
        ];
    }
	/* public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['date_entered']
				],
				'value' => new Expression('NOW()'),
			],
			[
				'class' => BlameableBehavior::className(),
				'createdByAttribute' => 'user_id'
			],
		];
	} */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
