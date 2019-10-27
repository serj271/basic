<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use app\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\IntegrityException;
use yii\db\Expression;
use yii\behaviors\AttributeTypecastBehavior; 
use yii\helpers\VarDumper;
use dastin\csv\models\CsvData;
/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class CsvBasic extends CsvData
{
    public function getCsvControl()
	{
		return $this->fileObject->getCsvControl();
	}
	public function setCsvControl($delimiter, $enclosure,$escape)
	{
		$this->fileObject->setCsvControl($delimiter, $enclosure, $escape);
	}
	public function parse()
	{
		
//		$pagination->getOffset();
		return $this->prepareModels();
	}
	public function setPageCount($count=1)
	{
		$pagination = $this->getPagination();
		$pagination->setPage($count);
	}
	public function getPageCount()
	{
		$pagination = $this->getPagination();
		return $pagination->getPageCount();
	}
}
