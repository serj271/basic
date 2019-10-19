<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $uri
 * @property string $name
 * @property string $description
 * @property string $primary_photo_id
 * @property int $visible
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Parcel[] $parcels
 * @property ProductPhoto[] $productPhotos
 */
class ProductForm extends \yii\db\ActiveRecord
{
	public $uri;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','uri', 'name'], 'required'],
			[['uri'], 'unique','when' => function ($model, $attribute) {
               return $model->{$attribute} !== $model->getOldAttribute($attribute);
//					return true;
			}],
            [['description'], 'string'],
            [['visible'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
//            [['uri', 'name', 'primary_photo_id'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uri' => 'Uri',
            'name' => 'Name',
            'description' => 'Description',
            'primary_photo_id' => 'Primary Photo ID',
            'visible' => 'Visible',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParcels()
    {
        return $this->hasMany(Parcel::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPhotos()
    {
        return $this->hasMany(ProductPhoto::className(), ['product_id' => 'id']);
    }
}
