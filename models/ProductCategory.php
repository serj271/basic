<?php

namespace app\models;
use Yii;
use yii\base;
use yii\db\Query;
use yii\helpers\VarDumper; 
use yii\db\ActiveRecord;
use app\components\UriValidator;

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
class ProductCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uri', 'name'], 'required'],
            [['description'], 'string'],
            [['parent_id'], 'integer'],
            [['uri', 'name', 'image'], 'string', 'max' => 64,
				'message'=>'Please enter a value for {attribute} too long'
			],
			['uri','unique', 'message'=>'{attribute} not unique']
//			['uri', 'validateUri'],
        ];
    }
	public function validateUri($attribute, $params)
    {
//        if (!in_array($this->$attribute, ['USA', 'Indonesia'])) {
            $this->addError($attribute, "$attribute not unique.");
//        }
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
          /*  'order' => 'Order',*/
            'parent_id' => 'Parent ID',
            'primary_photo_id' => 'Primary Photo ID',
            'image' => 'Image',
        ];
    }
	public function getProducts() { 
		return $this->hasMany(Product::className(), ['id' => 'product_id'])
			->viaTable('product_category_products', ['category_id' => 'id']);
	}
	/**
	 * Returns a full tree of nested product categories started at a category
	 *
	 * @param   int    $start
	 * @param   int    $stop      do not return this category ID
	 * @param   array  $order_by
	 * @return  array
	 */
	public static function full_tree($start = NULL, $stop = NULL, array $order_by = array('name', 'ASC'))//order
	{
		$tree = array();
		$query = new Query();
		$query
			->select(['id','name','parent_id','uri'])
			->from('product_category')
//			->leftJoin('product_photo','product_photo.product_id')
			->where(['parent_id' => $start])
			->orderBy([$order_by[0] => $order_by[1]]);
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
				'children' => self::full_tree($category['id'], $stop, $order_by)
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
	public static function reverse_tree($start)
	{
		$tree = array();

		$category = ProductCategory::findOne($start);

//		$tree[] = [$category->name];

		while ($category->parent_id)
		{
			$category = ProductCategory::findOne($category->parent_id);
			$tree[] = ['label' => $category->name,'url' => $category->uri];
		}

		return array_reverse($tree);
	}
	public static function getCategories()
	{
		return ProductCategory::find()->all();
	}
	public function addProduct($prosuct_id, $categori_id){

    }
}
