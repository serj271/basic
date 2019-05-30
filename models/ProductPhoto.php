<?php

namespace app\models;
use yii\db\ActiveRecord;
use app\models\Product;
use yii\behaviors\TimestampBehavior;
use yii\db\IntegrityException;
use yii\db\Expression;
use Yii;
use yii\behaviors\AttributeTypecastBehavior;


/**
 * This is the model class for table "product_photo".
 *
 * @property int $id
 * @property int $product_id
 * @property string $path_fullsize
 * @property string $path_thumbnail
 *
 * @property Products $product
 */
class ProductPhoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_photo';
    }
	
	public $upload;
	
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
                    'product_id' => AttributeTypecastBehavior::TYPE_INTEGER,//TYPE_STRING FLOAT
                    'path_thumbnail' => AttributeTypecastBehavior::TYPE_STRING,//TYPE_STRING FLOAT
                    'path_fullsize' => AttributeTypecastBehavior::TYPE_STRING,//TYPE_STRING FLOAT
                ],
 //               'typecastAfterValidate' => true,
 //               'typecastBeforeSave' => false,
  //              'typecastAfterFind' => false,
            ],
		];
	}
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'path_fullsize', 'path_thumbnail'], 'required'],
			[['product_id'], 'integer'],
            [['path_fullsize', 'path_thumbnail'], 'string', 'max' => 255, 'min'=>2],
            [['product_id', 'path_fullsize'], 'unique', 'targetAttribute' => ['product_id', 'path_fullsize']],
			/* [['upload'], 'file', 'extensions' => 'png, jpg, gif'], */
 //           [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductPhoto::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];//function ($attribute, $params)
    }
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['insert'] = ['product_id', 'path_thumbnail'];
		/* $scenarios['register'] = ['email', 'password', 'name']; */
		return $scenarios;
	}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'path_fullsize' => 'Path Fullsize',
            'path_thumbnail' => 'Path Thumbnail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
	
}
