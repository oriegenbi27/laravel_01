<?php

namespace App\Library;
use App\Log_aktifitas;
use App\Log_finance;
use App\Http\Controllers\Controller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;


use Illuminate\Support\Facades\Config;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;

class SendToApi extends Controller
{
  
  public function crud($url , $method , $data, $type=null){
    $token   = Session::get('ka_token');
    $url     = Config::get('constant.endpoint.url') .$url;

    $keterangan = [];
      try{

        $header = ['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json'];
        $client = new Client(['headers' => $header]);
          if($data){

            if($type=="multipart"){
              $response = $client->request($method, $url, [
                'multipart' => $data
            ]);
            
            }else{
              $response = $client->request($method, $url, [
                'form_params' => $data,
            ]);
              $explode = explode('api', $url);
              $ket = array($data);
              $logAktifitas['id_user']    = session()->get('profile')->id;
              $logAktifitas['id_owner']   = session()->get('profile')->id_owner;
              $logAktifitas['menu_api']   = $url;
              $logAktifitas['menu_web']   = $explode[1];
              $logAktifitas['action']     = $method;
              $logAktifitas['keterangan'] = json_encode($ket);

              $this->log_aktifitas($logAktifitas);
            }              
          }else{
            $response = $client->request($method, $url);
          }
            $body = $response->getBody();
            $json = json_decode($body);

            return $json;

      }catch (Exception $e) {
        return $e ;
      }
  }

  public function log_aktifitas($data){
    $parameter  = new Log_aktifitas();
    $parameter->id_user    = $data['id_user'];
    $parameter->id_owner   = $data['id_owner'];
    $parameter->menu_api   = $data['menu_api'];
    $parameter->menu_web   = $data['menu_web'];
    $parameter->action     = $data['action'];
    $parameter->keterangan = $data['keterangan'];
    $parameter->save();

    return $parameter;
  }

 
  public function Log_finance($data){
    $log_finance                      = [];
    $log_finance                      = new Log_finance();
    $log_finance['code']              = $data['code'];
    $log_finance['id_user']           = $data['id_user'];
    $log_finance['id_owner']          = $data['id_owner'];
    $log_finance['amount']            = $data['amount'];
    $log_finance['id_differential']   = $data['id_differential'];
    $log_finance['no_bukti']          = $data['no_bukti'];
    $log_finance['nama_perkiraan']    = $data['nama_perkiraan'];
    $log_finance['nama_pendapatan']   = $data['nama_pendapatan'];
    $log_finance['debit']             = $data['debit'];
    $log_finance['kredit']            = $data['kredit'];
    $log_finance['action']            = $data['action'];
    $log_finance->save();

    return $log_finance;
  }
 
}