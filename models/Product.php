<?php

namespace app\models;
use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
//use yii\db\IntegrityException;
use yii\db\Exception;
use yii\db\Expression;
//use Yii;
use yii\behaviors\AttributeTypecastBehavior;
use yii\helpers\VarDumper;

//use app\models\ProductCategories;
//use yii\helpers\VarDumper;
//use \Datetime;
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
    const HAS_MANY = 'has_many';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }
	public $title = 'product';

	public $relations = [];

	private $_values = [];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','uri'], 'required', 'message' => 'Please choose a value.'],
			/* [['uri'], 'unique','when' => function ($model, $attribute) {
               return $model->{$attribute} !== $model->getOldAttribute($attribute);
			}], */
			[['uri'], 'unique','targetAttribute' => ['uri'], 'message' => ' {attribute} not unique {value}'],
            ['description', 'string', 'max' => 500],
			['description', 'safe'],//optional description
			['description', 'default', 'value' => NULL],
            [['primary_photo_id'],  'number', 'integerOnly' => true, 'min' => 1, 'max' => 120,
'tooSmall' => 'You must be at least 13 to use this site.'],
			[['visible'],  'number', 'integerOnly' => true, 'min' => 1, 'max' => 2,
			'tooSmall' => 'You must be from 0 to 2 use this site.'],     
            [['name','uri'], 'string', 'max' => 255],
			[['name','description'], 'filter', 'filter' => 'trim'],
//			[['created_at', 'updated_at'],'number'],
			[['created_at', 'updated_at'],'datetime', 'format' => 'php:Y-m-d H:i:s','message' => 'Format is wrong'],
			[['category_list'], 'safe']
			/* ['pass', 'string', 'length' => [6,20] ], */
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
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
				'value' => new Expression('NOW()'),
			],
			'typecast' => [
                'class' => AttributeTypecastBehavior::className(),
                'attributeTypes' => [
                    'id' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'name' => AttributeTypecastBehavior::TYPE_STRING,//TYPE_STRING FLOAT
                    'description' => AttributeTypecastBehavior::TYPE_STRING,//TYPE_STRING FLOAT
                    'primary_photo_id' => AttributeTypecastBehavior::TYPE_INTEGER,//TYPE_STRING FLOAT
 //                   'is_active' => AttributeTypecastBehavior::TYPE_BOOLEAN,
                    'visible' => AttributeTypecastBehavior::TYPE_INTEGER,
					/* 'created_at' => function ($value) {
						$date = DateTime::createFromFormat('Y-m-d H:i:s', $value);
						if($date instanceof DateTime){
							$new_value = $date->getTimestamp();
						} else {
							$new_value = (int)$value;
						}						
						return $new_value;
					},
					*/
                ],
 //               'typecastAfterValidate' => true,
 //               'typecastBeforeSave' => false,
  //              'typecastAfterFind' => false,
            ],
		
				[
				'class' => \app\components\behaviors\ManyHasManyBehavior::className(),
					'relations' => [
						'category' => 'category_list',                   
					],
				],
		];
	}
	public function relations()
    {
        return array(
            'photo'=>array(self::HAS_MANY, 'product', 'product_id',
 //                           'order'=>'posts.create_time DESC',
                            'with'=>'product'),
			'category'=>array(self::HAS_MANY, 'ProductCategory', 'product_id')
            /* 'profile'=>array(self::HAS_ONE, 'Profile', 'owner_id'), */
        );
    }
	public function getPhotos() { 
		return $this->hasMany(ProductPhoto::className(), ['product_id' => 'id']); //get active query
	}
	public function getParcels() { 
		return $this->hasMany(Parcel::className(), ['product_id' => 'id']); 
	}

	public function getCategory()
	{
        try {
            return $this->hasMany(ProductCategory::className(),
                ['id' => 'category_id'])->viaTable('product_category_product', ['product_id' => 'id']);
        } catch (InvalidConfigException $e) {
                //echo $e->getName();
            throw new \yii\web\HttpException(404, $e->getName());
        }
    }
    public function addCategory($category_id){
        try {
            /** @var Integer $id */
            \Yii::$app->db
                ->createCommand()
                ->insert('product_category_product', [
                    'product_id' => $this->id,
                    'category_id' => $category_id
                ])
                ->execute();
            return 0;
        } catch (Exception $e) {
         //   Yii::info(VarDumper::dumpAsString($e->getMessage()));
            return $e->getMessage();
        }
    }
    public function updateCategory($category_id){
        try {
            /** @var Integer $id */
            \Yii::$app->db
                ->createCommand()
                ->update('product_category_product', ['category_id'=>$category_id],
                    [
                    'product_id' => $this->id
                    ]
                )
                ->execute();
            return 0;
        } catch (Exception $e) {
            //   Yii::info(VarDumper::dumpAsString($e->getMessage()));
            return $e->getMessage();
        }
    }

	
}
