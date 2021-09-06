<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\GroupCustomer ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GroupCustomerController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }

    public function GetDataGroupCustomer(){
      $id_owner = auth()->user()->id_owner;
      $GroupCustomer = GroupCustomer::Where('id_owner' , $id_owner)->get();

      $response = [];
      if($GroupCustomer){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $GroupCustomer,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }
      return response()->json($response);

    }

    public function find_group_customer(Request $request , $id){
      $id_owner = auth()->user()->id_owner;
      $GroupCustomer     = GroupCustomer::where('id', $id)
                                        ->where('id_owner', $id_owner)
                                        ->first();
      $response = [];
      if($GroupCustomer){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $GroupCustomer,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }
      return response()->json($response);
    }

    public function add_group_customer(Request $request){

      if($request->isMethod('GET')){
        return view('admin.groupcustomerAdd');
      }else{

        $parameter = $request->all();

         $GroupCustomer              = new GroupCustomer();
         $GroupCustomer->code        = $parameter['codegc'];
         $GroupCustomer->nama        = $parameter['nama'];
         $GroupCustomer->level       = $parameter['level'];
         $GroupCustomer->diskon      = $parameter['diskon'];
         $GroupCustomer->keterangan  = $parameter['keterangan'];
         $GroupCustomer->id_owner    = $parameter['id_owner'];
         $GroupCustomer->save();
         
         $response = [];
      if($GroupCustomer){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $GroupCustomer,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }

         return response()->json($response,200);
      }


    }
    public function edit_group_customer(Request $request){
      $enc = base64_decode($request->get('code'));
      $exp = explode('::', $enc);
      $id  = $exp[0];
 
      if($request->isMethod('GET')){
        return view('admin.groupcustomerEdit');
      }else{


        $parameter = $request->all();


         $id                         = $parameter['id'];
         $GroupCustomer              = GroupCustomer::find($id);
         $GroupCustomer->code        = $parameter['codegc'];
         $GroupCustomer->nama        = $parameter['nama'];
         $GroupCustomer->level       = $parameter['level'];
         $GroupCustomer->diskon      = $parameter['diskon'];
         $GroupCustomer->keterangan  = $parameter['keterangan'];
         $GroupCustomer->id_owner    = $parameter['id_owner'];
         $GroupCustomer->save();
         
         $response = [];
      if($GroupCustomer){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $GroupCustomer,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }

         return response()->json($response);
      }


    }

    public function delete_group_customer(Request $request , $id){
      $GroupCustomer   = GroupCustomer::where('id' , $id)->delete();
       
      $response = [];
      if($GroupCustomer){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $GroupCustomer,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }

      return response()->json($response);
    }



}
