<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Supplier ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SupplierController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }

    private function checkUser($email)
    {
        $id_owner = auth()->user()->id_owner;
        $supplier = Supplier::where('email', $email)
                            ->where('id_owner' , $id_owner)
                            ->first();
        return $supplier;
    }

    public function GetDataSupplier(){
      $id_owner = auth()->user()->id_owner;
      $supplier = supplier::where('id_owner' , $id_owner)->get();

      $response = [];
      if($supplier){
        $response = [
            'message' => 'Berhasil Delete ',
            'data'    => $supplier,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal Delete ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }
      return response()->json($response);

    }

    public function find_supplier($id){
      $supplier = Supplier::where('id' , $id)->get()->ToArray();

      $response = [];
      if($supplier){
        $response = [
            'message' => 'Berhasil Delete ',
            'data'    => $supplier,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal Delete ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }

      return response()->json($response);
    }

    public function add_supplier(Request $request){

      if($request->isMethod('GET')){
      
        $response = [];
        if($supplier){
          $response = [
              'message' => 'Berhasil Delete ',
              'data'    => $supplier,
              'code' => '000',
              'tipe' => 'sukses',
            ];
        }else{
          $response = [
            'message' => 'Gagal Delete ',
            'code' => '001',
            'tipe' => 'gagal',
          ];
        }
  
        return response()->json($response);
      }else{

        $parameter = $request->only('nama' ,
                                    'email' ,
                                    'tlp' ,
                                    'hp' ,
                                    'npwp' ,
                                    'prov' ,
                                    'kab' ,
                                    'kec' ,
                                    'kel' ,
                                    'addr' );

         $id_owner = auth()->user()->id_owner;
         $supplier          = new Supplier();
         $supplier->nama    = strtolower($parameter['nama']);
         $supplier->email   = strtolower($parameter['email']);
         $supplier->tlp     = strtolower($parameter['tlp']);
         $supplier->hp      = strtolower($parameter['hp']);
         $supplier->npwp    = strtolower($parameter['npwp']);
         $supplier->prov    = strtolower($parameter['prov']);
         $supplier->kab     = strtolower($parameter['kab']);
         $supplier->kec     = strtolower($parameter['kec']);
         $supplier->kel     = strtolower($parameter['kel']);
         $supplier->addr    = strtolower($parameter['addr']);
         $supplier->id_owner= $id_owner;

         $supplier->save();
         
         $response = [];
         if($supplier){
           $response = [
               'message' => 'Berhasil Delete ',
               'data'    => $supplier,
               'code' => '000',
               'tipe' => 'sukses',
             ];
         }else{
           $response = [
             'message' => 'Gagal Delete ',
             'code' => '001',
             'tipe' => 'gagal',
           ];
         }
   

         return response()->json($response,200);
      }


    }
    public function edit_supplier(Request $request){
      $code = base64_decode($request->get('code'));
      $exp  = explode('::',$code);
      $id   = $exp[1];
      if($request->isMethod('GET')){
        return view('admin.supplierEdit');
      }else{


        $parameter = $request->only('id',
                                    'nama' ,
                                    'email' ,
                                    'tlp' ,
                                    'hp' ,
                                    'npwp' ,
                                    'prov' ,
                                    'kab' ,
                                    'kec' ,
                                    'kel' ,
                                    'addr',
                                    'id_owner');


         $id = $parameter['id'];
         $id_owner = auth()->user()->id_owner;

         $supplier        = Supplier::find($id);
         $supplier->nama  = strtolower($parameter['nama']);
         $supplier->email = strtolower($parameter['email']);
         $supplier->tlp   = strtolower($parameter['tlp']);
         $supplier->hp    = strtolower($parameter['hp']);
         $supplier->npwp  = strtolower($parameter['npwp']);
         $supplier->prov  = strtolower($parameter['prov']);
         $supplier->kab   = strtolower($parameter['kab']);
         $supplier->kec   = strtolower($parameter['kec']);
         $supplier->kel   = strtolower($parameter['kel']);
         $supplier->addr  = strtolower($parameter['addr']);
         $supplier->id_owner = $id_owner;

         $supplier->save();
         
         $response = [];
         if($supplier){
           $response = [
               'message' => 'Berhasil Delete ',
               'data'    => $supplier,
               'code' => '000',
               'tipe' => 'sukses',
             ];
         }else{
           $response = [
             'message' => 'Gagal Delete ',
             'code' => '001',
             'tipe' => 'gagal',
           ];
         }
   

         return response()->json($response);
      }


    }

    public function delete_supplier(Request $request){
      $code = base64_decode($request->get('code'));
      $exp  = explode('::',$code);
      $id   = $exp[1];
      $supplier = Supplier::where('id', $id)->delete();
      $response = [];
      if($supplier){
        $response = [
            'message' => 'Berhasil Delete ',
            'data'    => $supplier,
            'code' => '000',
            'tipe' => 'sukses',
          ];
      }else{
        $response = [
          'message' => 'Gagal Delete ',
          'code' => '001',
          'tipe' => 'gagal',
        ];
      }


      return response()->json($response);
    }

}
