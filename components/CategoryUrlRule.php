<?php

namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use yii\helpers\VarDumper;
use app\models\ProductCategories;

class CategoryUrlRule extends BaseObject  implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)//create route for Html::a('Click Me', ['news/items-list', 'year' => 2015])
    {
        //If a parameter is defined and not empty - add it to the URL
        $url = 'categories/';
		if ($route === 'categories'){
			if (array_key_exists('url', $params) && !empty($params['url'])) {
				$url .= $params['url'];
			}
			return $url;
		}
		
       /*  if (array_key_exists('subcategory', $params) && !empty($params['subcategory'])) {
            $url .= ',' . $params['subcategory'];
        } */
//		return $url;
		return false;  // this rule does not apply
    }

    public function parseRequest($manager, $request)//for controller
    {
        $pathInfo = $request->getPathInfo();
		Yii::info(VarDumper::dumpAsString($pathInfo));
//        if (preg_match('%^product-categories/(/(\w))$%', $pathInfo, $matches)) {
//			Yii::info(VarDumper::dumpAsString($matches));
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
//			return ['news/index',[]];
//			return ['product-category/view',['category'=>$matches[2]]];
//			return ['product-categories/view',['url'=>'uri_18']];
//        }
		if (preg_match('%^categories/(?P<url>[_A-Za-z-0-9-]+)?%', $pathInfo, $matches)) {
			if(!isset($matches['url'])){
				return false;
			}
			$category = ProductCategories::find()->where(['uri' => $matches['url']])->one();
			if($category == NULL)
				return false;
//			Yii::info(VarDumper::dumpAsString($matches));
           /*  $route = Route::findRouteByUrl($matches['url']);
            if (!$route) {
                return false;
            }
            $params = $route['params'];
            $params['url'] = $route['url']; */
		return ['product-categories/view',['uri'=> $matches['url']]];
        }
//		if (preg_match('%^news/items-list(/(\w+))$%', $pathInfo, $matches)) {
//			Yii::info(VarDumper::dumpAsString($matches)); news/items-list/business
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
//			return ['news/index',[]];
//			return ['news/items-list',['category'=>$matches[2]]];
 //       }
		/* if (preg_match('%^([^\/]*)\/([^\/]*)$%', $pathInfo, $matches)) {
			if($matches[1] == 'news')
			{
				$params = [ 'title' => $matches[2]];
				return ['news/item-detail', $params];
			}
			else
			{
				return false;
			}
		} */
        return false;  // this rule does not apply
    }
}
