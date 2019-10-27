<?php 
namespace app\common\components;
use Yii;

class CurlGetHelpers
{	
	public static function get($url, $id = NULL)
	{
		$curl = curl_init(); //Starting handle.
			if($id){
				curl_setopt_array($curl, array(
				CURLOPT_HTTPPROXYTUNNEL => false,
//				CURLOPT_URL => 'http://192.168.1.1/basic/web/json/json-product/index',
				CURLOPT_URL => $url,
				CURLOPT_POST => false,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POSTFIELDS => json_encode(
					['id'=>$id]
				),
#				CURLOPT_POSTFIELDS => json_encode(
#					Arr::merge($data, 
#					array('token'=>Security::token()))
#				), //converting $data to JSON.
				CURLOPT_HTTPHEADER => array(
					"accept: application/json",
					"content-type: application/json",
					"X-Requested-With: XMLHttpRequest"
				),
			));
			} else {
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
			}
			
			$result = '';
			$resp = curl_exec($curl);

			if (curl_errno ( $curl )) {
				echo curl_error ( $curl );	
				curl_close ( $curl );
				exit ();
			} else {
				$getinfo = curl_getinfo($curl);
				$responses = (array)json_decode($resp, TRUE);//get array of Std class			
				$message = '';
				/* if($getinfo['http_code'] == 200){
					if(is_array($responses)){
						foreach($responses as $response) {
							foreach($response as $key=>$value){
								if(is_string($value)){
									$message = $message.' key - '.$key.' value - '.$value."\n";
								}							
							}
						}				
					} else {
						foreach($responses as $key=>$value){
							$message = $message.' key - '.$key.' value - '.$value;
						}
					}
				} else {
					if(isset($responses['message'])){
						$message = $message.$responses['message'];
					}					
				}	
							
				$result = $message.' -- code -- '.$getinfo['http_code']; */
	//			var_dump($errors); 
			}		
			curl_close($curl);
			
			return [
				$responses,
				$getinfo
			];
	}
		
}
			
		
		

