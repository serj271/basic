<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parcel".
 *
 * @property int $id
 * @property int $product_id
 * @property string $code
 * @property int $height
 * @property int $width
 * @property int $depth
 *
 * @property Products $product
 */
class Parcel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parcel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'code', 'height', 'width', 'depth'], 'required'],
            [['product_id', 'height', 'width', 'depth'], 'integer'],
            [['code'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 
				'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']
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
            'product_id' => 'Product ID',
            'code' => 'Code',
            'height' => 'Height',
            'width' => 'Width',
            'depth' => 'Depth',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
