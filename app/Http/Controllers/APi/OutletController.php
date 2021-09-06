<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DetailProduk;
use App\Outlet;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use App\Library\Images; 

class OutletController extends Controller
{
  protected $bundling;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }
  protected function schedule(Schedule $schedule)
  {
      $schedule->call(function () {
          DB::table('mst_bundling')->whereRaw('tgl_akhir > now()')->update(['flag' => 0]);
      })->daily();
  }

    public function DataOutlet(Request $request){ 
    
        $id_owner = auth()->user()->id_owner;
        $parameter = $request->all();
        $serching='';
  
        $colom=['updated_at','nama','','','',''];
        $orderby=$colom[$parameter['order']];
        $sort=$parameter['dir'];
  
        if (!empty($parameter['serch'])) {
          $serching=$parameter['serch'];
          $outlet=Outlet::where('id_owner' , $id_owner)
                  ->where(function($query) use ($serching){
                      $query->where('nama', 'LIKE', '%'.$serching.'%');
                            // ->orWhere('phone', 'LIKE', '%'.$serching.'%')
                            // ->orWhere('email', 'LIKE', '%'.$serching.'%');
                  })
                  ->limit($parameter['length'])->offset($parameter['start'])->orderBy($orderby,$sort)->get();
      }else{
  
    
          $outlet=Outlet::where('id_owner' , $id_owner)
                   ->limit($parameter['length'])->offset($parameter['start'])->orderBy($orderby,$sort)->get();
          
        }
      $array=array('data'=>$outlet,'count'=>Outlet::count());
      return response()->json($array);
        
    }

    public function GetDataBundling(){

      $id_owner = auth()->user()->id_owner;
     
        $bundling = Bundling::where('id_owner' , $id_owner)
                ->Where('flag' , 1)
                ->with(['gratis','item'])
                ->get();


                $response = []; 
                if($bundling){
                  $response = [
                      'message' => 'Berhasil ',
                      'data'    => $bundling,
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

  public function add_outlet(Request $request){
    if($request->isMethod('GET')){
      return view('admin.outletAdd');
    }else{

      $parameter = $request->all();
      
      $user_id        = auth()->user()->id;
      $id_owner       = auth()->user()->id_owner;

     
       $outlet                     = new Outlet();
       $outlet->code               = Outlet::generateCode($id_owner,'OUT');
       $outlet->nama               = $parameter['nama'];
       $outlet->password           = base64_encode($parameter['password']);
       $outlet->alamat             = $parameter['alamat'];
       $outlet->tgl_awal           = $parameter['awal'];
       $outlet->tgl_akhir          = $parameter['akhir'];
       $outlet->id_owner           = $id_owner;
       $outlet->save();
       

       
     
        $response = [];
        if($outlet){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $outlet,
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

  public function find_outlet(Request $request , $id){
    $id_owner = auth()->user()->id_owner;
    $outlet     = Outlet::where('id', $id)
                  ->where('id_owner', $id_owner)
                  ->first();
    $response = [];
    if($outlet){
      $response = [
          'message' => 'Berhasil ',
          'data'    => $outlet,
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

  public function edit_outlet(Request $request){
    // $decode = base64_decode($request->get('code'));
    // $exp = explode('::', $decode);
    // $id  = $exp[1];

    if($request->isMethod('GET')){
      return view('admin.groupcustomerEdit');
    }else{


      $parameter = $request->all();

      $id=$parameter['id'];
      $outlet                     = Outlet::find($id);
      $outlet->nama               = $parameter['nama'];
      $outlet->password           = base64_encode($parameter['password']);
      $outlet->alamat             = $parameter['alamat'];
      $outlet->tgl_awal           = $parameter['awal'];
      $outlet->tgl_akhir          = $parameter['akhir'];
      $outlet->id_owner           = $parameter['id_owner'];
      $outlet->save();
       
       $response = [];
    if($outlet){
      $response = [
          'message' => 'Berhasil ',
          'data'    => $outlet,
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
  

  public function delete_outlet(Request $request){
    $parameter = $request->all();
    $outlet = Outlet::where('id' , $parameter['id'] )->first();
    $flag=$outlet->flag;

    if($flag>0){
      $outlet->update(['flag'=>0]);
    }else{
      $outlet->update(['flag'=>1]);
    }
    
    $massage=($flag>0?'non aktifkan':'aktifkan');

    $response = [];
    
    if($outlet){
      $response = [
          'message' => 'Berhasil ',
          'data'    => $outlet,
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
