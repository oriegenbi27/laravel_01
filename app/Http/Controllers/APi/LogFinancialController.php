<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class LogFinancialController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }    

    public function GetDataFinance(){
      // $id_user  = auth()->user()->id;
      // $id_owner = auth()->user()->id_owner;
      // $Log = LogFinancial::where('id_user' , $id_user)
      //                     ->where('id_owner', $id_owner);
      // if($Log){
      //   $response = [
      //       'message' => 'Berhasil ',
      //       'data'    => $Log,
      //       'code' => '000',
      //       'tipe' => 'sukses',
      //     ];
      // }else{
      //   $response = [
      //     'message' => 'Gagal ',
      //     'code' => '001',
      //     'tipe' => 'gagal',
      //   ];
      // }  
      // return response()->json($response);

    }

      
    
}   
