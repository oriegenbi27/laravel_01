<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Brand ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class BrandController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }    

    public function GetDataBrand(){
      $id_owner = auth()->user()->id_owner;
      $brand = Brand::where('id_owner' , $id_owner)->get();

      $response = [];
          if($brand){
            $response = [
                'message' => 'Berhasil ',
                'data'    => $brand,
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

    public function find_brand(Request $request , $id){
      $brand     = Brand::find($id);
      $response = [];
          if($brand){
            $response = [
                'message' => 'Berhasil ',
                'data'    => $brand,
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

    public function add_brand(Request $request){

      if($request->isMethod('GET')){
        return view('admin.brandAdd');
      }else{

        $parameter = $request->only(
                                    // 'user_id' , 
                                    // 'pegawai_id' , 
                                    'nama' , 
                                    'keterangan', 
                                    'images'
                                   );
      
        $photo = $request->file('images');

        $filename = preg_replace('/\s+/', '',$parameter['nama']).time().'.'.$photo->getClientOriginalExtension();
        $storeFile = Storage::putFileAs(
            'public/brand', $photo, $filename
        );
         $id_owner = auth()->user()->id_owner;
         $brand              = new Brand();
         $brand->user_id     = strtolower(auth()->user()->id);
         $brand->nama        = strtolower($parameter['nama']);
         $brand->keterangan  = strtolower($parameter['keterangan']);
         $brand->images      = $filename;
         $brand->pegawai_id  = strtolower(auth()->user()->id);
         $brand->id_owner    = $id_owner;

         $brand->save();
         $response = [];
          if($brand){
            $response = [
                'message' => 'Berhasil ',
                'data'    => $brand,
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
    public function edit_brand(Request $request){
     
      if($request->isMethod('GET')){
        return view('admin.brandEdit');
      }else{


        $parameter = $request->only('user_id' , 
                                    'pegawai_id' , 
                                    'nama' , 
                                    'keterangan', 
                                    'images' );
        
        // if ($this->checkUser($parameter['email']) != null) {
        //   return response()->json(['message' => 'Mohon maaf, pengguna sudah terdaftar.'], 406);
        //  }

         $id                 = $parameter['id'];         
         $brand              = Brand::find($id);
         $brand->brand_id    = strtolower($parameter['brand_id']);
         $brand->user_id     = strtolower($parameter['user_id']);
         $brand->nama        = strtolower($parameter['nama']);
         $brand->keterangan  = strtolower($parameter['keterangan']);
         $brand->images      = $parameter['images'];
         $brand->pegawai_id  = strtolower($parameter['pegawai_id']);

         $brand->save();
         $response = [];
          if($brand){
            $response = [
                'message' => 'Berhasil ',
                'data'    => $brand,
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
    
    public function delete_brand(Request $request , $id){
        $brand     = Brand::where('id', $id)->delete();
        $response = [];
          if($brand){
            $response = [
                'message' => 'Berhasil ',
                'data'    => $brand,
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
