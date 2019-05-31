<?php

namespace app\models;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\IntegrityException;
use yii\db\Expression;
use Yii;
use yii\behaviors\AttributeTypecastBehavior;

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
            [['name', 'description','uri'], 'required', 'message' => 'Please choose a value.'],
            [['description'], 'string'],
			[['visible'], 'number'],
            [['primary_photo_id','visible'],  'number', 'integerOnly' => true, 'min' => 1, 'max' => 120,
'tooSmall' => 'You must be at least 13 to use this site.'],      
            [['name','uri'], 'string', 'max' => 255],
			[['name','description'], 'filter', 'filter' => 'trim'],
			[['created_at', 'updated_at'],'number'],
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
          /*   'avg_review_rating' => 'Avg Review Rating', */
            'visible' => 'Visible',
			'created_at'=>'created at',
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
			'typecast' => [
                'class' => AttributeTypecastBehavior::className(),
                'attributeTypes' => [
                    'id' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'name' => AttributeTypecastBehavior::TYPE_STRING,//TYPE_STRING FLOAT
                    'description' => AttributeTypecastBehavior::TYPE_STRING,//TYPE_STRING FLOAT
                    'primary_photo_id' => AttributeTypecastBehavior::TYPE_INTEGER,//TYPE_STRING FLOAT
 //                   'is_active' => AttributeTypecastBehavior::TYPE_BOOLEAN,
                    'visible' => AttributeTypecastBehavior::TYPE_INTEGER,
					'created_at'=>AttributeTypecastBehavior::TYPE_INTEGER,
					'updated_at'=>AttributeTypecastBehavior::TYPE_INTEGER,
                ],
 //               'typecastAfterValidate' => true,
 //               'typecastBeforeSave' => false,
  //              'typecastAfterFind' => false,
            ],
		];
	}
	
	public function getProductPhotos() { 
		return $this->hasMany(ProductPhoto::className(), ['product_id' => 'id']); //get active query
	}
	public function getParcels() { 
		return $this->hasMany(Parcel::className(), ['product_id' => 'id']); 
	}
	
	
}
