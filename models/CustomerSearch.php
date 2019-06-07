<?php

namespace app\models;

use Yii;
use app\models\Customer;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $phone_number
 */
class CustomerSearch extends \yii\db\ActiveRecord
{
	public $nameAndSurname;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           /*  [['name', 'surname'], 'required'],
            [['name', 'surname', 'phone_number'], 'string', 'max' => 64], */
			[['nameAndSurname'], 'safe']
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
            'surname' => 'Surname',
            'phone_number' => 'Phone Number',
        ];
    }
	public function search($params) {
		$query = Customer::find();
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
	 
		$this->addCondition($query, 'id');
		$this->addCondition($query, 'name', true);
		$this->addCondition($query, 'surname', true);
		/* $this->addCondition($query, 'country_id'); */
	 
		// filter by name
		$query->andWhere('name LIKE "%' . $this->nameAndSurname . '%" ' .
			'OR surname LIKE "%' . $this->nameAndSurname . '%"'
		);
	 
		return $dataProvider;
	}
}
