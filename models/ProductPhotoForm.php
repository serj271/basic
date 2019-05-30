<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_photo".
 *
 * @property int $id
 * @property int $product_id
 * @property string $path_fullsize
 * @property string $path_thumbnail
 *
 * @property Product $product
 */
class ProductPhotoForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_photo';
    }
	
	public $imageFile;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'path_fullsize', 'path_thumbnail'], 'required'],
            [['product_id'], 'integer'],
            [['path_fullsize', 'path_thumbnail'], 'string', 'max' => 64],
			[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => ['png, jpg'],'checkExtensionByMimeType'=>false],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
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
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
