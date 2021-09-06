<?php
namespace App\Library;
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

class ImagesToBase64 extends Controller
{
  public function EncryptToBase64($data){
    $extension      =  $data->getClientOriginalExtension();

    // valid extension
    $ValidExtension = array("jpeg" , "png" , "jpg");

    // Check extension

    if(in_array(strtolower($extension) , $ValidExtension)){
   
      $path     = $data->getRealPath();
      $isipath  = file_get_contents($path);
      $encrypt  = base64_encode($isipath);
      return $encrypt ;
    }
  }
}

?>