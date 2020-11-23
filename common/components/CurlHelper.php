<?php


namespace app\common\components;
use Yii;
use yii\helpers\VarDumper;


class CurlHelper
{
    public static function getAll($url)
    {
        $curl = curl_init(); //Starting handle.

            curl_setopt_array($curl, array(
                CURLOPT_HTTPPROXYTUNNEL => false,
                CURLOPT_URL => $url,
                CURLOPT_POST => false,
                CURLOPT_RETURNTRANSFER => true,
                  /*CURLOPT_POSTFIELDS => json_encode( // set post request
                      ['id'=>$id]
                  ),*/
                #				CURLOPT_POSTFIELDS => json_encode(
                #					Arr::merge($data,
                #					array('token'=>Security::token()))
                #				), //converting $data to JSON.
                CURLOPT_HTTPHEADER => array(
                    "accept: application/json",
                    //       "content-type: application/json",//set post
                    "X-Requested-With: XMLHttpRequest" //set ajax
                ),
            ));
        $result = '';
        $resp = curl_exec($curl);

        if (curl_errno ( $curl )) {
            echo curl_error ( $curl );
   //         Yii::info(VarDumper::dumpAsString( $responses ));
        } else {
            $getinfo = curl_getinfo($curl);

            $responses = (array)json_decode($resp, TRUE);//get array of Std class
   //         Yii::info(VarDumper::dumpAsString( $responses ));
            $message = '';
            if($getinfo['http_code'] == 200){
                foreach($responses as $response) {
                    foreach($response as $key=>$value){
                        if(is_string($value)){
                            $message = $message.' - '.$key.' - '.$value;
                        }
                    }
                }
            } else {
                if(isset($responses['message'])){
                    $message = $message.$responses['message'];
                }
            }

            $result = $message.' -- code -- '.$getinfo['http_code'];
            //			var_dump($errors);

        }
        curl_close($curl);

        return $result;
    }

    public static function getOne($url, $id)
    {
        $curl = curl_init(); //Starting handle.
        curl_setopt_array($curl, array(
            CURLOPT_HTTPPROXYTUNNEL => false,
            CURLOPT_URL => $url,
            CURLOPT_POST => false,
            CURLOPT_RETURNTRANSFER => true,
            /*CURLOPT_POSTFIELDS => json_encode(
                array_merge(
                    [
                        'id'=>1,
                    ],[]
                    [
                        "_csrf"=>Yii::$app->request->getCsrfToken()
                    ]
                )

            ), *///converting $data to JSON.
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "X-Requested-With: XMLHttpRequest",
            ),
        ));
        $result = '';
        $resp = curl_exec($curl);

        if (curl_errno ( $curl )) {
            echo curl_error ( $curl );
//			Log::instance()->add(Log::NOTICE, Debug::vars('---er',curl_error ( $curl )));
            Yii::info(VarDumper::dumpAsString( curl_error ( $curl ) ));
            curl_close ( $curl );
            exit ();
        } else {
            $getinfo = curl_getinfo($curl);
            $responses = (array)json_decode($resp, TRUE);//get array of Std class
//Log::instance()->add(Log::NOTICE, Debug::vars('responses',$responses));
            $message = '';
            if($getinfo['http_code'] == 200){
                foreach($responses as $key=>$value){
                    $message = $message.' key - '.$key.' value - '.$value;
                }
            }
            $result = $message.' -- code -- '.$getinfo['http_code'];
//			var_dump($responses);
        }
        curl_close($curl);
//		Log::instance()->add(Log::NOTICE, Debug::vars('resp ---',$resp,$data, $uri, $field));

        return $result;

    }
}