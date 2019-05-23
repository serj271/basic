<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_photos".
 *
 * @property int $id
 * @property int $product_id
 * @property string $path_fullsize
 * @property string $path_thumbnail
 *
 * @property Products $product
 */
class ProductPhotos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_photos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'path_fullsize', 'path_thumbnail'], 'required'],
            [['product_id'], 'integer'],
            [['path_fullsize', 'path_thumbnail'], 'string', 'max' => 255],
            [['product_id', 'path_fullsize'], 'unique', 'targetAttribute' => ['product_id', 'path_fullsize']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
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
            'path_fullsize' => 'Path Fullsize',
            'path_thumbnail' => 'Path Thumbnail',
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
