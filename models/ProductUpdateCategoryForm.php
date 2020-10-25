<?php

namespace app\models;
use app\models\Product;
use app\models\ProductCategories;
use yii\base\Model;
use yii\helpers\VarDumper; 

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
class ProductUpdateCategoryForm extends Model
{
	private $_product;
    private $_productCategories;
    private $_categories;
    /**
     * @var \app\models\Product|mixed|null
     */
     private $product;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Product'], 'required'],
            [['ProductCategories'], 'safe'],
        ];
    }
	 public function afterValidate()
    {
        $error = false;
        if (!$this->product->validate()) {
            $error = true;
        }
        if (!$this->productCategories->validate()) {
            $error = true;
        }
        if ($error) {
            $this->addError(null); // add an empty error to prevent saving
        }
        parent::afterValidate();
    }

    public function update($runValidation = true, $attributeNames = NULL)
    {
//		
		$this->product->category_list = [$this->productCategories->id];
//		Yii::info(VarDumper::dumpAsString($this->productCategories));
//		if (!$this->product->update()) {
 //          $transaction->rollBack();
//           return false;
//		}
		if (!$this->validate()) {
		   return false;
		}
		$transaction = Yii::$app->db->beginTransaction();

		if (!$this->product->update()) {
			$transaction->rollBack();
			return false;
		}
		$transaction->commit();
        return true;
    }
	public function save()
    {
        if (!$this->validate()) {
            return false;
        }
		$this->product->validate();
		$this->product->category_list = [$this->productCategories->id];
        $transaction = Yii::$app->db->beginTransaction();
        if (!$this->product->save()) {
            $transaction->rollBack();
            return false;
        }
        /* $this->parcel->product_id = $this->product->id;
        if (!$this->parcel->save(false)) {
            $transaction->rollBack();
            return false;
        } */
        $transaction->commit();
        return true;
    }

    public function getProduct()
    {
        return $this->_product;
    }

    public function setProduct($product)
    {
//		Yii::info(VarDumper::dumpAsString($product));
        if ($product instanceof Product) {
            $this->_product = $product;
        } else if (is_array($product)) {		
            $this->_product = Product::findOne($product['id']);
			$this->_product->setAttributes($product);
        }
    }

    public function getProductCategories()
    {
        if ($this->_productCategories === null) {
            if ($this->product->isNewRecord) {
                $this->_productCategories = new ProductCategories();
  //              $this->_productCategories = ProductCategories::findOne(1);
 //               $this->_productCategories->loadDefaultValues();
            } else {
                $this->_productCategories = $this->product->category;
            }
        }
        return $this->_productCategories;
    }

    public function setProductCategories($productCategories)
    {
//		Yii::info(VarDumper::dumpAsString($productCategories));
        if (is_array($productCategories)) {
			$this->_productCategories = ProductCategories::findOne($productCategories['id']);
            $this->productCategories->setAttributes($productCategories);
        } elseif ($productCategories instanceof ProductCategories) {
            $this->_productCategories = $productCategories;
        }
    }

    public function errorSummary($form)
    {
        $errorLists = [];
        foreach ($this->getAllModels() as $id => $model) {
            $errorList = $form->errorSummary($model, [
                'header' => '<p>Please fix the following errors for <b>' . $id . '</b></p>',
            ]);
            $errorList = str_replace('<li></li>', '', $errorList); // remove the empty error
            $errorLists[] = $errorList;
        }
        return implode('', $errorLists);
    }

    private function getAllModels()
    {
        return [
            'Product' => $this->product,
            'ProductCategories' => $this->productCategories,
        ];
    }
}
