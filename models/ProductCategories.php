<?php

namespace app\models;
use Yii;
use yii\base;
use yii\db\Query;
use yii\helpers\VarDumper; 
use yii\db\ActiveRecord;

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
class ProductCategories extends \yii\db\ActiveRecord
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
	public function getProducts() { 
		return $this->hasMany(Product::className(), ['id' => 'product_id'])
			->viaTable('product_categories_products', ['category_id' => 'id']); 
	}
	/**
	 * Returns a full tree of nested product categories started at a category
	 *
	 * @param   int    $start
	 * @param   int    $stop      do not return this category ID
	 * @param   array  $order_by
	 * @return  array
	 */
	public function full_tree($start = NULL, $stop = NULL, array $order_by = array('name', 'ASC'))//order
	{
		$tree = array();
		$query = new Query();
		$query
			->select(['id','name','parent_id'])
			->from($this->tableName())
//			->leftJoin('product_photo','product_photo.product_id')
			->where(['parent_id' => $start])
			->orderBy($order_by[0], $order_by[1]);
//			->asArray()
//			->all();
	/* 	$product_categories = ORM::factory('Product_Category')
			->where('parent_id', '=', $start)
			->order_by($order_by[0], $order_by[1])
			->find_all(); */
//		Yii::info(VarDumper::dumpAsString($query->all()));
		$product_categories = $query->all();
		foreach ($product_categories as $category)
		{
			if ($stop == $category['id'])
				continue;
//			Yii::info(VarDumper::dumpAsString($category));
			$tree[] = $category + array(
				'children' => $this->full_tree($category['id'], $stop, $order_by)
			);
		}
		return $tree;
	}

	/**
	 * Gets the reverse tree of categories, selecting the first parent. Useful
	 * when need to generate breadcrumb type feature
	 *
	 * @param   int   $start
	 * @return  array
	 */
	/* public function reverse_tree($start)
	{
		$tree = array();

		$category = ORM::factory('Product_Category', $start);
		$tree[] = $category;

		while ($category->parent_id)
		{
			$category = ORM::factory('Product_Category', $category->parent_id);
			$tree[] = $category;
		}

		return array_reverse($tree);
	}  */
}
