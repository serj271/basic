<?php

namespace app\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\IntegrityException;
use yii\db\Expression;
use yii\behaviors\AttributeTypecastBehavior;
use app\models\Customer;

/**
 * This is the model class for table "reservation".
 *
 * @property int $id
 * @property int $room_id
 * @property int $customer_id
 * @property string $price_per_day
 * @property string $date_from
 * @property string $date_to
 * @property string $reservation_date
 */
class Reservation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['room_id', 'customer_id', 'price_per_day', 'date_from', 'date_to'], 'required'],
            [['room_id', 'customer_id'], 'integer'],
            [['price_per_day'], 'number'],
            [['date_from', 'date_to', 'reservation_date'], 'safe'],
			[['date_from', 'date_to'], 'date', 'format' => 'yyyy-m-d'],
        ];
    }
	public function behaviors()
	{
		return [
			'typecast' => [
                'class' => AttributeTypecastBehavior::className(),
                'attributeTypes' => [
                  /*   'id' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'name' => AttributeTypecastBehavior::TYPE_STRING,//TYPE_STRING FLOAT
                    'description' => AttributeTypecastBehavior::TYPE_STRING,//TYPE_STRING FLOAT
                    'primary_photo_id' => AttributeTypecastBehavior::TYPE_INTEGER,//TYPE_STRING FLOAT
 //                   'is_active' => AttributeTypecastBehavior::TYPE_BOOLEAN,
                    'visible' => AttributeTypecastBehavior::TYPE_INTEGER,
					'created_at'=>AttributeTypecastBehavior::TYPE_INTEGER,
					'updated_at'=>AttributeTypecastBehavior::TYPE_INTEGER, */
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_id' => 'Room ID',
            'customer_id' => 'Customer ID',
            'price_per_day' => 'Price Per Day',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'reservation_date' => 'Reservation Date',
        ];
    }
	public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
