<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class News extends Model
{
	public $title;
	public $content;
	
	public function attributeLabels()
    {
        return [
            'title' => 'Title of news',
            'content' =>  \Yii::t('app','content of news'),
        ];
    }
	public function fields()
	{
		$fields = parent::fields();

		// удаляем поля, содержащие конфиденциальную информацию
//		unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);

		return $fields;
	}
	public function rules()
	{
		return [
			[['title', 'content'], 'required'],
			['title', 'content'],
		];
	}
}