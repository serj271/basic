<?php

namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use yii\helpers\VarDumper;


class CustomerUrlRule extends BaseObject  implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)//create route for Html::a('Click Me', ['reservations/grid', 'Reservation[customer_id]' => 2])
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
		/* if ($route !== 'reservations/grid/') {
          return false;
		} */
        //If a parameter is defined and not empty - add it to the URL
        /* $url = 'reservations/grid';
        if (array_key_exists('Reservation[customer_id]', $params) && !empty($params['Reservation[customer_id]'])) {
            $url .= $params['Reservation[customer_id]'];
        } */
		/* if (array_key_exists('category', $params) && !empty($params['category'])) {
            $url .= $params['category'];
        } */
       /*  if (array_key_exists('subcategory', $params) && !empty($params['subcategory'])) {
            $url .= ',' . $params['subcategory'];
        } */
//		return $url;
        return false;  // this rule does not apply
    }

    public function parseRequest($manager, $request)//for controller
    {
        $pathInfo = $request->getPathInfo();
//		Yii::info(VarDumper::dumpAsString($pathInfo));
        if (preg_match('%^reservations/grid(/(\d{4}))$%', $pathInfo, $matches)) {
//			Yii::info(VarDumper::dumpAsString($matches));
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
//			return ['news/index',[]];
			return ['reservations/grid',['Reservation[customer_id]'=>$matches[2]]];
        }
		/* if (preg_match('%^news/items-list(/(\w+))$%', $pathInfo, $matches)) {
//			Yii::info(VarDumper::dumpAsString($matches)); news/items-list/business
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
//			return ['news/index',[]];
			return ['news/items-list',['category'=>$matches[2]]];
        } */
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
