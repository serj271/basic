<?php
namespace app\common\components;
// namespace app\components; // For Yii2 Basic (app folder won't actually exist)
class HelloHelpers
{
    public static function hello($name) {
        return "Hello $name";
    }
}