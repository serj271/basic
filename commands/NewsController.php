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
use yii\helpers\VarDumper;
use app\models\News;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class NewsController extends Controller
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
	public $message='default message';
    
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
       /*  echo $this->message . "\n";
		Yii::info('message log');
		Yii::info(VarDumper::dumpAsString(array('q'=>4)));
		Yii::debug('start calculating average revenue');
//		 $this->stdout("whatever");
		$name = $this->ansiFormat('Alex', Console::FG_YELLOW);
		echo "Hello, my name is $name."; */
//		$model = new News();
		/* $model->title = 'title 2';
		$model->content = 'content 2';
		$model->save(false); */
		/* $query = new \yii\db\Query();
		$query->select('id, title')
		->from('news')
		->limit(10);
		$command = $query->createCommand();
		$sql = $command->sql;
		$rows = $command->queryAll();
		Yii::info(VarDumper::dumpAsString(array($rows))); */
		$news = News::find()->orderBy('title')->all();
		Yii::info(VarDumper::dumpAsString(array($news)));
		$new = News::findOne(1);
		print_r ($new->title);
		print "\n";
		$news = News::find()->orderBy('title')->all();
		print_r ($news[0]->title);
		print "\n";
		$post=News::model()->findByPk(1);
		$post->title='Some new title';
		$post->save();
//		echo $model->getAttributeLabel('title');
//		$query = 'select title from news where ID=:ID';
		/* Yii::$app->my_db->createCommand($query)
                ->bindValue(':ID',1)
                ->queryOne(); */

		return ExitCode::OK;
    }
}
