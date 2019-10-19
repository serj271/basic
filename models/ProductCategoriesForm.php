<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_categories".
 *
 * @property int $id
 * @property string $uri
 * @property string $name
 * @property string $description
 * @property string $order
 * @property int $parent_id
 * @property string $primary_photo_id
 * @property string $image
 */
class ProductCategoriesForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uri', 'name', 'order'], 'required'],
            [['description'], 'string'],
            [['parent_id'], 'integer'],
            [['uri', 'name', 'order', 'primary_photo_id', 'image'], 'string', 'max' => 64],
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
            'order' => 'Order',
            'parent_id' => 'Parent ID',
            'primary_photo_id' => 'Primary Photo ID',
            'image' => 'Image',
        ];
    }
}
