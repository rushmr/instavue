<?php
namespace App\Classes;

class Vkservice
{
  public static function api($method, $params){ 
    return json_decode(self::curl("https://api.vk.com/method/" . $method . "?" . http_build_query($params)),1); 
  }

  public static function curl($url, $post = null){

    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417
    Firefox/3.0.3');
    if($post){
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    $response = curl_exec( $ch );
    curl_close( $ch );

    return $response;
  }

}


?>