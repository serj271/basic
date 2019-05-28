<?php

namespace app\controllers;

class ProductPhotoController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
	public function actionCreate()
    {
        return $this->render('create');
    }

}
