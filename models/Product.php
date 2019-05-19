<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property string $uri
 * @property string $description
 * @property int $primary_photo_id
 * @property string $avg_review_rating
 * @property int $visible
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }
	public $title = 'product';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['description'], 'string'],
            [['primary_photo_id', 'visible'], 'integer'],
            [['avg_review_rating'], 'number'],
            [['name', 'uri'], 'string', 'max' => 255],
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
            'uri' => 'Uri',
            'description' => 'Description',
            'primary_photo_id' => 'Primary Photo ID',
            'avg_review_rating' => 'Avg Review Rating',
            'visible' => 'Visible',
        ];
    }
}
