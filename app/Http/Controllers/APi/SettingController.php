<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Setting ;
use App\LogPrefensi;
use App\LogFinancial ;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class SettingController extends Controller
{
  protected $client;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }    

    public function GetDataSetting(){
      $id_owner = auth()->user()->id_owner;
      $setting = Setting::find($id_owner);

      if($setting){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $setting,
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

    public function find_setting(Request $request , $id){
      $setting     = Setting::find($id);
      if($setting){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $setting,
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

    public function setting_dashboard(Request $request){

      $parameter    = $request->only('nama', 'email' , 'tlp' , 'hp' , 'npwp' , 'prov' , 'kab' , 'kec' , 'kel' , 'kode_pos' ,'addr' , 'longlat' , 'time' ,'tipe_bisnis' , 'images');                                       
      $id_owner     = auth()->user()->id_owner;
      $find         = Setting::find($id_owner);
      $photo        = $request->file('images');

      if(isset($find)){
        $setting            = $find;
        $messege            = 'Berhasil Edit';
      }else{
        $setting            = new Setting();
        $setting->id_owner  = $id_owner;
        $messege            = 'Berhasil Setting';
      }

      if($photo){
        $filename     = preg_replace('/\s+/', '',$parameter['nama']).time().'.'.$photo->getClientOriginalExtension();
        $storeFile    = Storage::putFileAs('public/icon', $photo, $filename);  
      }else{
        $filename     = $find->images;
      }

      $setting->nama        = strtolower($parameter['nama']);
      $setting->email       = strtolower($parameter['email']);
      $setting->tlp         = strtolower($parameter['tlp']);
      $setting->hp          = strtolower($parameter['hp']);
      $setting->npwp        = strtolower($parameter['npwp']);
      $setting->prov        = strtolower($parameter['prov']);
      $setting->kab         = strtolower($parameter['kab']);
      $setting->kec         = strtolower($parameter['kec']);
      $setting->kel         = strtolower($parameter['kel']);
      $setting->kode_pos    = strtolower($parameter['kode_pos']);
      $setting->time        = strtolower($parameter['time']);
      $setting->longlat     = strtolower($parameter['longlat']);
      $setting->tipe_bisnis = strtolower($parameter['tipe_bisnis']);
      $setting->addr        = strtolower($parameter['addr']);
      $setting->images      = $filename ;
      $setting->save();

      if($setting){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $setting,
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


    public function preferensi(Request $request){
     
      if($request->isMethod('GET')){
        $id_user = auth()->user()->id;
        $id_owner = auth()->user()->id_owner;

        $data    = LogPrefensi::orderBy('id', 'ASC')
                               ->where('id_owner' , $id_owner)
                               ->where('id_user' , $id_user)
                               ->get()->toArray();
        if($data){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $data,
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
      }else {
        $parameter = $request->only('tipeakun' , 'nama');
        $no_parent = $request->get('tipeakun');
        $id_user  = auth()->user()->id;
        $id_owner = auth()->user()->id_owner;

        $sql  = LogPrefensi::where('akun_induk' , $no_parent)
                           ->where('id_owner' , $id_owner)
                           ->where('id_user' , $id_user)
                           ->get();
        
        $data = [];
        $data_sql = [];
        $data_kode_perkiraan = [];
        foreach($sql as $row){
          $data_sql['kode_perkiraan'] = $row->kode_perkiraan;
          $data_sql['tipe_akun']      = $row->tipe_akun;
          array_push($data_kode_perkiraan , $row->kode_perkiraan);
        }
          $nama      = $request->get('nama');
          $arr_last  = $data_kode_perkiraan[count($data_kode_perkiraan)-1];
          $count     = count($nama);
          for($i = 0 ; $i < $count ; $i++ ){
              // $data = $sql;                      
              $data                 = new LogPrefensi();
              $data->id_user        = auth()->user()->id;
              $data->id_owner       = auth()->user()->id_owner;
              $data->kode_perkiraan = $arr_last++ ;
              $data->tipe_akun      = $data_sql['tipe_akun'];
              $data->nama           = $request->get('nama')[$i];
              $data->save();
          };

          if($data){
            $response = [
                'message' => 'Berhasil ',
                'data'    => $data,
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
        }

      return response()->json($response);
    }
   
    public function preferensi_pivot(Request $request){
      
    }
    
}   
