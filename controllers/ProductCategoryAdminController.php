<?php

namespace app\controllers;

class ProductCategoryAdminController extends \yii\web\Controller
{
    public function actionEdit()
    {
        return $this->render('edit');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView()
    {
        return $this->render('view');
    }

}
