<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;


class ShowCommand extends ConsoleCommand
{
    public function actionHello($name) {
        echo 'Hello, ' . $name . '!' . PHP_EOL;
    }
}
