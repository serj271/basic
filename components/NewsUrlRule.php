<?php

namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use yii\helpers\VarDumper;


class NewsUrlRule extends BaseObject  implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)//create route for Html::a('Click Me', ['news/items-list', 'year' => 2015])
    {
//		Yii::info(VarDumper::dumpAsString($params,$manager, $route));
       /*  if ($route === 'car/index') {
            if (isset($params['manufacturer'], $params['model'])) {
                return $params['manufacturer'] . '/' . $params['model'];
            } elseif (isset($params['manufacturer'])) {
                return $params['manufacturer'];
            }
        } */
		/*if ($route === 'news/item-detail') {
		 	if (isset($params['title'])) {
				return 'news/'.$params['title'];
			}
		} */
		if ($route !== 'news/items-list') {
          return false;
       }
        //If a parameter is defined and not empty - add it to the URL
        $url = 'news/';
        if (array_key_exists('year', $params) && !empty($params['year'])) {
            $url .= $params['year'];
        }
		/* if (array_key_exists('category', $params) && !empty($params['category'])) {
            $url .= $params['category'];
        }
        if (array_key_exists('subcategory', $params) && !empty($params['subcategory'])) {
            $url .= ',' . $params['subcategory'];
        } */
		return $url;
 //       return false;  // this rule does not apply
    }

    public function parseRequest($manager, $request)//for controller
    {
        $pathInfo = $request->getPathInfo();
//		Yii::info(VarDumper::dumpAsString($pathInfo));
        if (preg_match('%^news(/(\d{4}))$%', $pathInfo, $matches)) {
//			Yii::info(VarDumper::dumpAsString($matches));
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
//			return ['news/index',[]];
			return ['news/items-list',['year'=>$matches[2]]];
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
