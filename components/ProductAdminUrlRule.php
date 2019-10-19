<?php

namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use yii\helpers\VarDumper;
use app\models\Product;

class ProductAdminUrlRule extends BaseObject  implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)//create route for Html::a('Click Me', ['news/items-list', 'year' => 2015])
    {		
        //If a parameter is defined and not empty - add it to the URL
//		Yii::info(VarDumper::dumpAsString($route));
        $url = 'product-admin/';
		if ($route === 'product-admin'){
//			Yii::info(VarDumper::dumpAsString($params));
			if (array_key_exists('action', $params) && !empty($params['action'])) {
				$url .= $params['action'].'/';
			}
			if (array_key_exists('id', $params) && !empty($params['id'])) {
				$url .= $params['id'];
			}
			return $url;
		}
       /*  if (array_key_exists('subcategory', $params) && !empty($params['subcategory'])) {
            $url .= ',' . $params['subcategory'];
        } */
        return false;  // this rule does not apply
    }

    public function parseRequest($manager, $request)//for controller
    {
        $pathInfo = $request->getPathInfo();
//		Yii::info(VarDumper::dumpAsString($pathInfo));
        if (preg_match('%^product-admin\/(?P<action>[A-Za-z]+)\/(?P<id>[_A-Za-z-0-9-]+)?%', $pathInfo, $matches)) {
			if(!isset($matches['action'])){
				return false;
			}
			if(!in_array($matches['action'],['create','delete','edit','view','updatecategory','createcategory'])){
				return false;
			}			
			if(!isset($matches['id'])){
				return false;
			}
			$product = Product::find()->where(['id' => $matches['id']])->one();

			if($product == NULL)
				return false;
			return ['product-admin/'.$matches['action'],['id'=> $matches['id']]];
        }
		
        return false;  // this rule does not apply
    }
}
