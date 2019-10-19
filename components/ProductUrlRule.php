<?php

namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use yii\helpers\VarDumper;
use app\models\Product;

class ProductUrlRule extends BaseObject  implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)//create route for Html::a('Click Me', ['news/items-list', 'year' => 2015])
    {//		
		/* if ($route !== 'news/items-list') {
          return false;
		} */
        //If a parameter is defined and not empty - add it to the URL
        $url = 'product/';
		if ($route === 'product'){
			if (array_key_exists('url', $params) && !empty($params['url'])) {
				$url .= $params['url'];
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
		/* $route = Route::findRouteByUrl($pathInfo);
            if (!$route) {
                return false;
            } */
		/* if (preg_match('%^product/$%', $pathInfo, $matches)) {
			return ['product/view'];
		} */
        if (preg_match('%^product/(?P<url>[_A-Za-z-0-9-]+)?%', $pathInfo, $matches)) {			
			if(!isset($matches['url'])){
				return false;
			}
			$category = Product::find()->where(['uri' => $matches['url']])->one();
			if($category == NULL)
				return false;
//			Yii::info(VarDumper::dumpAsString($matches));
           /*  $route = Route::findRouteByUrl($matches['url']);
            if (!$route) {
                return false;
            }
            $params = $route['params'];
            $params['url'] = $route['url']; */
			return ['product/view',['uri'=> $matches['url']]];
        }
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
