<?php

namespace app\controllers;

use Yii;

use app\models\ProductPhotoForm;
use app\models\ProductPhoto;
use app\models\Product;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use app\models\UploadForm;
use yii\web\UploadedFile;

class ProductPhotoController extends \yii\web\Controller
{
	public $imageFile;
	
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
		$model_upload = new UploadForm();
		if (Yii::$app->request->isPost) {
            $model_upload->imageFile = UploadedFile::getInstance($model_upload, 'imageFile');//$model_upload->imageFile->baseName type size error
			Yii::info(VarDumper::dumpAsString($model_upload));
			if ($model_upload->imageFile && $model_upload->validate()){
				$model_upload->imageFile->saveAs('uploads/' . 'file' . '.' . $model_upload->imageFile->extension);
				if ($model->save(false)) {
					return $this->redirect(['view', 'id' => $model->id]);
				}
			}			
 //           if ($model_upload->upload()) {
				/* if ($model->save(false)) {
					return $this->redirect(['view', 'id' => $model->id]);
				} */
                // file is uploaded successfully
 //               return;
//            }
        }		
//		$this->handlePostSave($model);
//		$this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);

	/* 	return $this->render('create', [
			'model' => $model,
		]); */
		/* 
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$modelCanSave = true;
//			$model->load(\Yii::$app->request->post());
			$model->save();
		}*/
        return $this->render('create',[
			'model' => $model,
			'model_upload'=>$model_upload,
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
		$photo = ProductPhoto::findOne($id);
		if($photo == NULL){
			throw new \yii\web\HttpException(404,
          "$id photo not found");
		}
		$products = ArrayHelper::map(Product::find()->asArray()->all(), 'id', 'name');
//		Yii::info(VarDumper::dumpAsString($photo));
		if ($photo->load(Yii::$app->request->post()) && $photo->validate()) {
			$photo->save();
			return $this->redirect(['view', 'id' => $photo->id]);
		}
		
		return $this->render('edit', [
			'photo'=>$photo,
			'products'=>$products
		]);
	}
	protected function handlePostSave(ProductPhotoForm $model)
	{
		if ($model->load(Yii::$app->request->post())) {
			$model->upload = UploadedFile::getInstance($model, 'upload');

			if ($model->validate()) {
				if ($model->upload) {
					$filePath = 'uploads/' . $model->upload->baseName . '.' . $model->upload->extension;
					if ($model->upload->saveAs($filePath)) {
//						$model->image = $filePath;

					}
				}

				if ($model->save(false)) {
					return $this->redirect(['view', 'id' => $model->id]);
				}
			}
		}
	}

}
