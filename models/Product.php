<?php

namespace app\models;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\IntegrityException;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property string $uri
 * @property string $description
 * @property int $primary_photo_id
 * @property string $avg_review_rating
 * @property int $visible
 */
class Product extends \yii\db\ActiveRecord
{
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }
	public $title = 'product';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required', 'message' => 'Please choose a username.'],
            [['description'], 'string'],
			[['visible'], 'integer'],
            [['primary_photo_id'],  'number', 'integerOnly' => true, 'min' => 13, 'max' => 120,
'tooSmall' => 'You must be at least 13 to use this site.'],
            [['avg_review_rating'], 'number'],
            [['name','uri'], 'string', 'max' => 255],
			[['name','description','visible','primary_photo_id','uri'], 'filter', 'filter' => 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'uri' => 'Uri',
            'description' => 'Description',
            'primary_photo_id' => 'Primary Photo ID',
            'avg_review_rating' => 'Avg Review Rating',
            'visible' => 'Visible',
        ];
    }
	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => 'yii\behaviors\TimestampBehavior',
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
				'value' => new Expression('NOW()'),
			],
		];
	}
	
	public function getProductPhotos() { 
		return $this->hasMany(ProductPhoto::className(), ['product_id' => 'id']); 
	}
	public function getParcels() { 
		return $this->hasMany(Parcel::className(), ['product_id' => 'id']); 
	}
	
	
}
