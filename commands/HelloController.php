<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use Yii;
use yii\base;
use yii\helpers\VarDumper;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
   /*  public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    } */
	public $message='default message1';
    
    public function options($actionID)
    {
        return ['message'];
    }
    
    public function optionAliases()
    {
        return ['m' => 'message'];
    }
    
    public function actionIndex()
    {
        echo $this->message . "\n";
		Yii::info('message log');
		Yii::info(VarDumper::dumpAsString(array('q'=>4)));
		Yii::debug('start calculating average revenue');
//		 $this->stdout("whatever");
		$name = $this->ansiFormat('Alex', Console::FG_YELLOW);
		echo "Hello, my name is $name.\n";
		
		
		
		
		return ExitCode::OK;
    }
}
//./yii hello hello --message="hello all"