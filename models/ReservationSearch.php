<?php

namespace app\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\IntegrityException;
use yii\db\Expression;
use yii\behaviors\AttributeTypecastBehavior;
use app\models\Reservation;

class ReservationSearch extends Reservation
{
	public $nameAndSurname;
	
	public static function tableName()
    {
        return 'reservation';
    }
	
	public function rules()
    {
        return [
         /*    [['name', 'surname'], 'required'],
            [['name', 'surname', 'phone_number'], 'string', 'max' => 64], */
			[['nameAndSurname'], 'safe']
        ];
    }
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
			'nameAndSurname'=>'name and surname'
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
	public function search($params) {
		$query = Reservation::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
	 
		/**
		 * before $this->load($params)
		 */
		$dataProvider->setSort([
			'attributes' => [
				'id',
				'nameAndSurname' => [
					'asc' => ['name' => SORT_ASC, 'surname' => SORT_ASC],
					'desc' => ['name' => SORT_DESC, 'surname' => SORT_DESC],
					'label' => 'Full Name',
					'default' => SORT_ASC
				],
				/* 'country_id' */
			]
		]);
	 
		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}
	 
		/* $this->addCondition($query, 'id');
		$this->addCondition($query, 'name', true);
		$this->addCondition($query, 'surname', true); */
		/* $this->addCondition($query, 'country_id'); */
	 
		// filter by name
		/* $query->andWhere('name LIKE "%' . $this->nameAndSurname . '%" ' .
			'OR surname LIKE "%' . $this->nameAndSurname . '%"'
		); */
		$query->andFilterWhere(['like', 'surname', $this->nameAndSurname]);
		return $dataProvider;
	}
    /* public function rules()
    {
 //       add related rules to searchable attributes
		return array_merge(parent::rules(),[ ['customer.surname', 'safe'] ]);		
    } */	

    /**
     * {@inheritdoc}
     */
   /*  public function attributeLabels()
    {
        return array_merge(parent::attributes(), ['customer.surname']);
    } */
	public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
	 
	
}
