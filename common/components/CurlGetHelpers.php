<?php 
namespace app\common\components;
use Yii;
use yii\helpers\VarDumper;

class CurlGetHelpers
{	
	public static function get($url, $id = NULL)
	{
		$curl = curl_init(); //Starting handle.
	//		if($id){
				curl_setopt_array($curl, array(
                    CURLOPT_HTTPPROXYTUNNEL => false,
                    CURLOPT_URL => $url,
                    CURLOPT_POST => false,
                    CURLOPT_RETURNTRANSFER => true,
                  /*  CURLOPT_POSTFIELDS => json_encode( // set post request
                        ['id'=>$id]
                    ),*/
    #				CURLOPT_POSTFIELDS => json_encode(
    #					Arr::merge($data,
    #					array('token'=>Security::token()))
    #				), //converting $data to JSON.
                    CURLOPT_HTTPHEADER => array(
                        "accept: application/json",
                 //       "content-type: application/json",
                        "X-Requested-With: XMLHttpRequest" //set ajax
                    ),
			    ));
		/*	} else {
				curl_setopt_array($curl, array(
                    CURLOPT_HTTPPROXYTUNNEL => false,
    //				CURLOPT_URL => 'http://192.168.1.1/basic/web/json/json-product/index',
                    CURLOPT_URL => $url,
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array(
                        "accept: application/json",
                        "content-type: application/json",
                        "X-Requested-With: XMLHttpRequest",

                    ),
			    ));
			}*/
			
			$result = '';
			$resp = curl_exec($curl);

			if (curl_errno ( $curl )) {
				echo curl_error ( $curl );	
				curl_close ( $curl );
				exit ();
			} else {
				$getinfo = curl_getinfo($curl);

				$responses = (array)json_decode($resp, TRUE);//get array of Std class
//                Yii::info(VarDumper::dumpAsString( $responses ));
				$message = '';
				if($getinfo['http_code'] == 200){
					foreach($responses as $key=>$value){
                        if(is_string($value)){
                            $message = $message.' key - '.$key.' value - '.$value;
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
	public function post($url, $id = NULL)
    {
        //		Log::instance()->add(Log::NOTICE, Debug::vars($uri));
        $curl = curl_init(); //Starting handle.
        curl_setopt_array($curl, array(
            CURLOPT_HTTPPROXYTUNNEL => false,
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode([]
           /*     Arr::merge($data,
                    array('token'=>Security::token()))*/
            ), //converting $data to JSON.
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
            Yii::info(VarDumper::dumpAsString(curl_error ( $curl )));
        //    Log::instance()->add(Log::NOTICE, Debug::vars('---er',curl_error ( $curl )));
            curl_close ( $curl );
            exit ();
        } else {
            $getinfo = curl_getinfo($curl);
            $responses = (array)json_decode($resp, TRUE);//get array of Std class
   //         Yii::info(VarDumper::dumpAsString($responses));
//				Log::instance()->add(Log::NOTICE, Debug::vars($getinfo));
            $message = '';
            if($getinfo['http_code'] == 200){

                    foreach($responses as $key=>$value){
                        if(is_string($value)){
                            $message = $message.' key - '.$key.' value - '.$value;
                        }
                    }

            } else {
//					Log::instance()->add(Log::NOTICE, Debug::vars('error',$getinfo,$responses));//
                foreach($responses as $key=>$value){
                    $message = $message.$key.'=>'.$value;
                }
            }

            $result = $message.' -- code -- '.$getinfo['http_code'];//$getinfo['http_code']
            //			var_dump($errors);
        }
       // Log::instance()->add(Log::NOTICE, Debug::vars($resp));
        curl_close($curl);
//			Log::instance()->add(Log::NOTICE, Debug::vars('resp ---',$message,$data, $uri));

        return $result;

    }
		
}
			
		
		

