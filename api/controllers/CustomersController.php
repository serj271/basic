<?php
namespace api\controllers;
use yii\rest\ActiveController;


class CustomersController extends ActiveController
{
    public $modelClass = 'models\Customer';

}
