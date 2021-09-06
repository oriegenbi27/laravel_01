<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DetailProduk;
use App\Bundling;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use App\Library\Images; 

class BundlingController extends Controller
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

    public function DataBundling(Request $request){ 
    
        $id_owner = auth()->user()->id_owner;
        $parameter = $request->all();
        $serching='';
  
        $colom=['updated_at','','judul','','',''];
        $orderby=$colom[$parameter['order']];
        $sort=$parameter['dir'];
  
        if (!empty($parameter['serch'])) {
          $serching=$parameter['serch'];
          $bundling=Bundling::where('id_owner' , $id_owner)->with(['gratis','item'])
                  ->where(function($query) use ($serching){
                      $query->where('judul', 'LIKE', '%'.$serching.'%');
                            // ->orWhere('phone', 'LIKE', '%'.$serching.'%')
                            // ->orWhere('email', 'LIKE', '%'.$serching.'%');
                  })
                  ->limit($parameter['length'])->offset($parameter['start'])->orderBy($orderby,$sort)->get();
      }else{
  
    
          $bundling=Bundling::where('id_owner' , $id_owner)->with(['gratis','item'])
                   ->limit($parameter['length'])->offset($parameter['start'])->orderBy($orderby,$sort)->get();
          
        }
      $array=array('data'=>$bundling,'count'=>Bundling::count());
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

  public function add_bundling(Request $request){
    if($request->isMethod('GET')){
      return view('admin.bundlingAdd');
    }else{

      $parameter = $request->all();
      
      $user_id        = auth()->user()->id;
      $id_owner       = auth()->user()->id_owner;

      $data['nama'] = $parameter['judul']; 
      $data['file'] = $request->file('images');
      $data['path'] = 'public/produk';
      $data['images'] = $parameter['images'];

      $move = new Images();
      $action = $move->MovePath($data);

       $bundling                     = new Bundling();
       $bundling->code               = strtolower($parameter['code']);
       $bundling->judul              = strtolower($parameter['judul']);
       $bundling->keterangan         = $parameter['ket'];
       $bundling->item               = $parameter['item'];
       $bundling->min_beli           = $parameter['minbeli'];
       $bundling->harga              = $parameter['harga'];
       $bundling->berat              = $parameter['berat'];
       $bundling->tbonus             = $parameter['tbonus'];
       $bundling->fitem              = $parameter['fitem'];
       $bundling->diskon             = $parameter['diskon'];
       $bundling->tgl_awal           = $parameter['awal'];
       $bundling->tgl_akhir          = $parameter['akhir'];
       $bundling->stock_bundling     = $parameter['stock'];
       $bundling->pusat              = $parameter['pusat'];
       $bundling->cabang             = $parameter['cabang'];
       $bundling->gambar             = $action; 
       $bundling->id_owner           = strtolower($id_owner);
       $bundling->save();
       

       
     
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
       
        return response()->json($response,200);
       
       
      
    }
  }

    

}
