<?php
namespace app\commands;

use \yii\console\Controller;
use yii\helpers\Console;
use Yii;
use yii\helpers\VarDumper; 

class BasicController extends Controller { 
	public function actionIndex()
	{
		echo "HelloWorld\n";
		return 0;
	}
	public function actionLivesIn($name, $city="Chicago")
	{
		echo "$name lives in $city.\n";
		return 0;
	}
	
	public function actionListElements(array $array)
	{
		foreach ($array as $k)
			echo "$k\n";
		return 0;
	}
	public function actionConditionalExit($shouldRun=0)
	{
		if ((int)$shouldRun < 0)
		{
			echo 'The $shouldRun argument must be an positive
			non-zero integer' . "\n";
			return 1;
		}
			return 0;
	}
	public function actionColors()
	{
		$this->stdout("Waiting on important thing to happen...\n",Console::BOLD);
		$yay = $this->ansiFormat('Yay', Console::FG_CYAN);
		echo "$yay! We're done!\n";
		return 0;
	}

}

//./yii basic/list-elements


