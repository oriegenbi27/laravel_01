<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DetailProduk;
use App\Promo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use App\Library\Images; 

class PromoController extends Controller
{
  protected $promo;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }

    public function DataPromo(Request $request){             
        $id_owner = auth()->user()->id_owner;
        $parameter = $request->all();
        $serching='';
  
        $colom=['updated_at','','judul','','',''];
        $orderby=$colom[$parameter['order']];
        $sort=$parameter['dir'];
  
        if (!empty($parameter['serch'])) {
          $serching=$parameter['serch'];
          $promo=Promo::where('id_owner' , $id_owner)->with(['gratis'])
                  ->where(function($query) use ($serching){
                      $query->where('judul', 'LIKE', '%'.$serching.'%');
                            // ->orWhere('phone', 'LIKE', '%'.$serching.'%')
                            // ->orWhere('email', 'LIKE', '%'.$serching.'%');
                  })
                  ->limit($parameter['length'])->offset($parameter['start'])->orderBy($orderby,$sort)->get();
      }else{
  
    
          $promo=Promo::where('id_owner' , $id_owner)->with(['gratis'])
                   ->limit($parameter['length'])->offset($parameter['start'])->orderBy($orderby,$sort)->get();
          
        }
      $array=array('data'=>$promo,'count'=>Promo::count());
      return response()->json($array);
        
    }

  public function add_promo(Request $request){
    if($request->isMethod('GET')){
      return view('admin.produkAdd');
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

       $promo                     = new Promo();
       $promo->code               = strtolower($parameter['code']);
       $promo->judul              = strtolower($parameter['judul']);
       $promo->keterangan         = $parameter['ket'];
       $promo->item               = $parameter['item'];
       $promo->min_beli           = $parameter['minbeli'];
       $promo->harga              = $parameter['harga'];
       $promo->tbonus             = $parameter['tbonus'];
       $promo->fitem              = $parameter['fitem'];
       $promo->diskon             = $parameter['diskon'];
       $promo->tgl_awal           = $parameter['awal'];
       $promo->tgl_akhir          = $parameter['akhir'];
       $promo->gambar             = $action; 
       $promo->id_owner           = strtolower($id_owner);
       $promo->save();
       

       
     
        $response = [];
        if($promo){
          $response = [
              'message' => 'Berhasil ',
              'data'    => $promo,
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
