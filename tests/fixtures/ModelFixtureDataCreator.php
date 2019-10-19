<?php
namespace app\tests\fixtures;

use yii\base\Exception;


/**
 * Class ModelFixtureDataCreator
 * @package app\tests\fixtures
 */
class ModelFixtureDataCreator {

    /**
     * Reads the CSV files from the test related fixture folder, instantiates
     * the model by the CSV filename without the file-extension and passes
     * it to the writeFixtureDataForModelIntoDb(); method with the modelname
     * and the test classname.
     *
     * @param $test_classname
     */
    public static function create($test_classname){
        $path__fixture_folder = 'fixtures/' . $test_classname;

        $handle__fixture_folder = opendir($path__fixture_folder);

        while (($file = readdir($handle__fixture_folder)) !== false){
            if(is_file($path__fixture_folder . '/' . $file)){

                $arr__pathinfo = pathinfo($file);
                $str__modelname = str_replace('.' . $arr__pathinfo['extension'],
                                                                    '', $file);

                $str__modelpath = 'app\\models\\' . $str__modelname;

                $obj__model_instance = new $str__modelpath;
                self::writeFixtureDataForModelIntoDb($obj__model_instance,
                                            $str__modelname, $test_classname);
            }

        }

    }

    /**
     * Uses the first line from the CSV file as the model properties. Then
     * the method treats the next lines as values and writes them to the model
     * related database table.
     *
     * @param $obj__model_instance
     * @param $str__modelname
     * @param $test_classname
     */
    private static function writeFixtureDataForModelIntoDb($obj__model_instance,
                                            $str__modelname, $test_classname){

        $fp = fopen("fixtures/$test_classname/$str__modelname" . '.csv', 'r');

        $first_row_runed = false;
        $properties = array();
        while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
            if($first_row_runed === false){
                $properties = $data;
            } else {
                $sub_counter = 0;
                foreach($data as $d){
                    $obj__model_instance->$properties[$sub_counter] = $d;
                    $sub_counter++;
                }
                $obj__model_instance->save();
            }

            $first_row_runed = true;
        }

    }


}
?>