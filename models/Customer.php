<?php

namespace app\models;
use app\components\MyBehavior;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $phone_number
 */
class Customer extends \yii\db\ActiveRecord
{
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
            [['name', 'surname'], 'required'],
            [['name', 'surname', 'phone_number'], 'string', 'max' => 64],
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
			'nameAndSurname'=>'Name and surname'
        ];
    }
	public function getReservationsCount()
	{
		return $this->hasMany(\app\models\Reservation::className(), ['customer_id' =>
		'id'])->count();
	}
	public function getNameAndSurname() {
		return $this->name.' '.$this->surname;
	}
	public function behaviors()
    {
        return [
            // anonymous behavior, behavior class name only
            MyBehavior::className(),

            // named behavior, behavior class name only
            'myBehavior2' => MyBehavior::className(),

            // anonymous behavior, configuration array
            [
                'class' => MyBehavior::className(),
                'prop1' => 'value1',
                'prop2' => 'value2',
            ],

            // named behavior, configuration array
            'myBehavior4' => [
                'class' => MyBehavior::className(),
                'prop1' => 'value1',
                'prop2' => 'value2',
            ]
        ];
    }
}
