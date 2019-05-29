<?php

namespace app\controllers;

use Yii;

use app\models\ProductPhotoForm;
use app\models\ProductPhoto;
use yii\helpers\VarDumper; 

class ProductPhotoController extends \yii\web\Controller
{
	
	
    public function actionIndex()
    {
		$photos = ProductPhoto::find()
			->indexBy('id')
			->asArray()
			->all();
//		Yii::info(VarDumper::dumpAsString($photos));
        return $this->render('index',[
			'photos'=>$photos,
			'width'=>\Yii::$app->params['thumbnail.size'][0],
			'height'=>\Yii::$app->params['thumbnail.size'][1]
		]);
    }
	public function actionCreate()
    {
		$modelCanSave = false;
		$model = new ProductPhotoForm();
		
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$modelCanSave = true;
			$model->load(\Yii::$app->request->post());
			$model->save();
		}
        return $this->render('create',[
			'model' => $model,
			'modelSaved' => $modelCanSave
			]
		);
    }
	public function actionView($id){
		$photo = ProductPhoto::findOne($id);
		if($photo == NULL){
			throw new \yii\web\HttpException(404,
          "$id photo not found");
		}
		return $this->render('view', [
			'photo'=>$photo,
			'width'=>\Yii::$app->params['thumbnail.size'][0],
			'height'=>\Yii::$app->params['thumbnail.size'][1]
		]);
		/* $model = new ProductPhoto();
		$attributes = $model->getAttributes();
		foreach(array_keys($attributes) as $key){
			echo "$key => ".$this->ansiFormat($photo[$key], Console::FG_YELLOW).".\n";
		}
		
//		Yii::info(VarDumper::dumpAsString($photo->getProduct()));
		$product = $photo->getProduct()->one();//active query to single row result

		$attributes = $product->attributes;
		if(count($attributes) != 0){
			echo "product name -----$photo->product->name\n";//from public method name
			foreach($attributes as $key=>$value){
				echo "$key => ".$this->ansiFormat($value, Console::FG_YELLOW).".\n";
			}	
		} */
	}
	public function actionEdit($id){
		
		return $this->render('edit');
	}

}
