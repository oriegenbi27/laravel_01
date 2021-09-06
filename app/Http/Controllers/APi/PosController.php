<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Pos ;
use App\PosDetail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PosController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  { 
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }
  

 public function CreateDetail(Request $request){

  $parameter = $request->only('id_produk' , 'qty' , 'harga' , 'diskon' , 'code' , 'id_user' , 'id_owner');
  
  //  $data[] = $request; 
  //  $insert = PosDetail::insert($request);
  $jml = $request[0]['ttl_item'];
  for($i=0 ; $i < $jml ; $i++){
    $PosDetail            = new PosDetail();
    $PosDetail->id_produk = $request[$i]['id_produk'];
    $PosDetail->code      = $request[$i]['code'];
    $PosDetail->id_owner  = $request[$i]['id_owner'];
    $PosDetail->qty       = $request[$i]['qty'];
    $PosDetail->harga     = $request[$i]['harga'];
    $PosDetail->diskon    = $request[$i]['diskon'];
    $PosDetail->id_user   = $request[$i]['id_user'];
    $PosDetail->save();
  }
  

    return response()->json($request);
 }

}
