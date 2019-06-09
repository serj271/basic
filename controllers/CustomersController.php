<?php

namespace app\controllers;
use app\models\Customer;
use yii\base;
use yii\db\Query;
use Yii;

class CustomersController extends \yii\web\Controller
{
    public function actionCreateMultipleModels()
    {
		$models = [];
		if(isset($_POST['Customer']))
		{
			$validateOK = true;
			foreach($_POST['Customer'] as $postObj)
			{
				$model = new Customer();
				$model->attributes = $postObj;
				$models[] = $model;
				$validateOK = ($validateOK && ($model->validate()));
			}
			// All models are validated and will be saved
			if($validateOK)
			{
				foreach($models as $model)
			{
				$model->save();
			}
			// Redirect to grid after save
				return $this->redirect(['grid']);
			}
		}
		else
		{
			for($k=0;$k<3;$k++)
			{
				$models[] = new Customer();
			}
		}
        return $this->render('create-multiple-models',['models' => $models]);
    }

}
