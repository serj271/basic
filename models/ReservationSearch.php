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
    public function rules()
    {
 //       add related rules to searchable attributes
		return array_merge(parent::rules(),[ ['customer.surname', 'safe'] ]);		
    }	

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributes(), ['customer.surname']);
    }
	
}
