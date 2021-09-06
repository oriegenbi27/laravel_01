<?php

namespace App\Http\Controllers\SendToApi;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Config;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class SendToApi extends SendToApii
{
  
  public function crud($url , $method , $data){
    $token   = Session::get('ka_token');
    $url = Config::get('constant.endpoint.url') .$url;

      try{

        $header = ['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json'];
        $client = new Client(['headers' => $header]);
          if(!$data){
            $response = $client->request($method, $url, [
                'form_params' => $data,
            ]);
          }else{
            $response = $client->request($method, $url);
          }
            $body = $response->getBody();
            $json = json_decode($body);

            return $json;
            // return Redirect::route($route) ;

      }catch (Exception $e) {
        return $e ;
      }
  }

}