<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\NewsForm;
use yii\helpers\VarDumper;

class NewsController extends Controller
{
    /**
     * {@inheritdoc}
     */
/*    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
*/
    /**
     * {@inheritdoc}
     */
	public function actions()//for static html pages /basic/web/index.php?r=news/pages&view=info
	{
		return [
			'pages' => [
			'class' => 'yii\web\ViewAction',
			],
		];
	}
	public function dataItems()
	{
		$newsList = [
		[ 'title' => 'First World War', 'date' => '1914-07-28' ],
		[ 'title' => 'Second World War', 'date' => '1939-09-01' ],
		[ 'title' => 'First man on the moon', 'date' => '1969-07-20' ]
		];
		return $newsList;
	}
	public function data()
	{
		return [
			[ "id" => 1, "date" => "2015-04-19", "category" => "business", "title" => "Test news
			of 2015-04-19" ],
			[ "id" => 2, "date" => "2015-05-20", "category" => "shopping", "title" => "Test news
			of 2015-05-20" ],
			[ "id" => 3, "date" => "2015-06-21", "category" => "business", "title" => "Test news
			of 2015-06-21" ],
			[ "id" => 4, "date" => "2016-04-19", "category" => "shopping", "title" => "Test news
			of 2016-04-19" ],
			[ "id" => 5, "date" => "2017-05-19", "category" => "business", "title" => "Test news
			of 2017-05-19" ],
			[ "id" => 6, "date" => "2018-06-19", "category" => "shopping", "title" => "Test news
			of 2018-06-19" ]
		];
	}

    public function actionIndex()
    {
        return $this->render('index');
    }
	public function actionItemsList()
	{
		$newsList = $this->dataItems();
		// if missing, value will be null
		$year = Yii::$app->request->get('year');
		// if missing, value will be null
		$category = Yii::$app->request->get('category');
		$data = $this->data();
		$filteredData = [];
		
		Yii::info(VarDumper::dumpAsString($data)); 
		foreach($data as $d)
		{
			if(($year != null)&&(date('Y', strtotime($d['date'])) == $year)) $filteredData[] =	$d;
			if(($category != null)&&($d['category'] == $category)) $filteredData[] = $d;
		}
		return $this->render('itemsList', ['year' => $year, 'category' => $category, 'newsList' => $newsList,
			'filteredData' => $filteredData] );
		/* $newsList = $this->dataItems();
		return $this->render('itemsList', ['newsList' => $newsList]); */
	}
	public function actionItemDetail($title)
	{
		$newsList = $this->dataItems();
		$item = null;
		foreach($newsList as $n)
		{
			if($title == $n['title']) $item = $n;
		}
		return $this->render('itemDetail', ['item' => $item]);
	}
	
	public function actionAdvTest()
	{
		$this->layout = 'responsive';
		return $this->render('advTest');
	}
    
}
