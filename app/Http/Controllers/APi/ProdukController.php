<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DetailProduk;
use App\Produk;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use App\Library\Images; 

class ProdukController extends Controller
{
  protected $produk;

  public function __construct(Client $client)
  {
      $this->middleware('APITokenJWT', ['except' => ['exns', 'cne']]);
      $this->client = new Client([
          'verify' => false
      ]);
  }

    public function GetDataProduk(){

      $id_owner = auth()->user()->id_owner;
     
        $produk = Produk::where('id_owner' , $id_owner)
                ->with(['jenisbarang','brand','subjenis'])
                ->get();


                $response = []; 
                if($produk){
                  $response = [
                      'message' => 'Berhasil ',
                      'data'    => $produk,
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

    public function DataProduk(Request $request){             
        $id_owner = auth()->user()->id_owner;
        $parameter = $request->all();
        $serching='';
  
        $colom=['updated_at','','nama','','','','','','',''];
        $orderby=$colom[$parameter['order']];
        $sort=$parameter['dir'];
  
        if (!empty($parameter['serch'])) {
          $serching=$parameter['serch'];
          $produk=Produk::where('id_owner' , $id_owner)->with(['brand','jenisbarang','subjenis'])
                  ->where(function($query) use ($serching){
                      $query->where('nama', 'LIKE', '%'.$serching.'%');
                            // ->orWhere('phone', 'LIKE', '%'.$serching.'%')
                            // ->orWhere('email', 'LIKE', '%'.$serching.'%');
                  })
                  ->limit($parameter['length'])->offset($parameter['start'])->orderBy($orderby,$sort)->get();
      }else{
  
        if(!empty($parameter['rank'])){
          $ranks=$parameter['rank'];
          // $ranks=explode(":",$ranks);

          $produk=Produk::where('id_owner' , $id_owner)->with(['brand','jenisbarang','subjenis'])
              ->where('jenis_barang_id',$ranks)
              ->limit($parameter['length'])->offset($parameter['start'])->orderBy('created_at','desc')->get();
      }else{
          $produk=Produk::where('id_owner' , $id_owner)->with(['brand','jenisbarang','subjenis'])
                   ->limit($parameter['length'])->offset($parameter['start'])->orderBy($orderby,$sort)->get();
          }
        }
      $array=array('data'=>$produk,'count'=>Produk::count());
      return response()->json($array);
        
    }

    public function find_produk($id){
      $produk     = Produk::with(['jenisbarang','brand','subjenis','detailproduk'])->find($id); 
      $response = [];
      if($produk){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $produk,
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

    public function add_produk(Request $request){

      if($request->isMethod('GET')){
        return view('admin.produkAdd');
      }else{

        $parameter = $request->all();
        
        $user_id        = auth()->user()->id;
        $id_owner       = auth()->user()->id_owner;

        $data['nama'] = $parameter['nama'];
        $data['file'] = $request->file('images');
        $data['path'] = 'public/produk';
        $data['images'] = $parameter['images'];

        $move = new Images();
        $action = $move->MovePath($data);

         $produk                     = new Produk();
         $produk->code               = strtolower($parameter['code']);
         $produk->brand_id           = strtolower($parameter['brand_id']);
         $produk->jenis_barang_id    = strtolower($parameter['jenis_barang_id']);
         $produk->sub_jenis_id       = $parameter['sub_jenis_barang_id'];
         $produk->user_id            = strtolower($user_id);
        
         $produk->nama               = strtolower($parameter['nama']);
         $produk->harga              = strtolower($parameter['harga']);
         $produk->diskon             = strtolower($parameter['diskon']);
         $produk->berat              = strtolower($parameter['berat']);
         $produk->unit               = strtolower($parameter['unit']);
         $produk->total_harga        = $parameter['totalharga'];
         $produk->ppn                = $parameter['ppn']; 
         $produk->stock              = strtolower($parameter['stock']);
         $produk->images             = $action; 
         $produk->id_owner           = strtolower($id_owner);

         $produk->save();
         $idkom=json_decode($parameter['idkom']);
         $namakom=json_decode($parameter['namakom']);
         $qtykom=json_decode($parameter['qtykom']);
         $satuankom=json_decode($parameter['satuankom']);
         
         if ($idkom==null) {
          $response = [];
          if($produk){
            $response = [
                'message' => 'Berhasil ',
                'data'    => $produk,
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
         }else{
          for ($i=0; $i < sizeof($idkom); $i++) {

            $detail=new DetailProduk(); 
            $detail->id_produk = $produk->id;
  
            $detail->id_komposisi = $idkom[$i];
            $detail->nama = $namakom[$i];
            $detail->qty = $qtykom[$i];
            $detail->satuan = $satuankom[$i];
            $detail->save();
  
           } 
           
  
           $response = [];
           if($produk){
             $response = [
                 'message' => 'Berhasil ',
                 'data'    => $produk,
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
    public function edit_produk(Request $request){

      if($request->isMethod('GET')){
        return view('admin.produkEdit');
      }else{


        $parameter = $request->all();
        $user_id        = auth()->user()->id;
        $id_owner       = auth()->user()->id_owner;
        $id             = $parameter['id'];
        $produk         = Produk::find($id);

        $data['nama'] = $parameter['nama'];
        $data['file'] = $request->file('images');
        $data['path'] = 'public/produk';
        $data['images'] = $produk['images'];

        $move = new Images();
        $action = $move->MovePath($data);

         $produk->brand_id           = $parameter['brand_id'];
         $produk->jenis_barang_id    = $parameter['jenis_barang_id'];
         $produk->sub_jenis_id       = $parameter['sub_jenis_barang_id'];
         $produk->user_id            = $user_id;
         $produk->nama               = $parameter['nama'];
         $produk->harga              = $parameter['harga'];
         $produk->diskon             = $parameter['diskon'];
         $produk->berat              = $parameter['berat'];
         $produk->unit               = $parameter['unit'];
         $produk->stock              = $parameter['stock'];
         $produk->total_harga        = $parameter['totalharga'];
         $produk->ppn                = $parameter['ppn'];
         $produk->images             = $action;
         $produk->id_owner           = $id_owner;
         $produk->save();
         $delete=DetailProduk::where('id_produk',$id)->delete();

         $idkom=json_decode($parameter['idkom']);
         $namakom=json_decode($parameter['namakom']);
         $qtykom=json_decode($parameter['qtykom']);
         $satuankom=json_decode($parameter['satuankom']);
         
         if ($idkom==null) {
          $response = [];
          if($produk){
            $response = [
                'message' => 'Berhasil ',
                'data'    => $produk,
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
         }else{
          for ($i=0; $i < sizeof($idkom); $i++) {

            $detail=new DetailProduk(); 
            $detail->id_produk = $produk->id;
  
            $detail->id_komposisi = $idkom[$i];
            $detail->nama = $namakom[$i];
            $detail->qty = $qtykom[$i];
            $detail->satuan = $satuankom[$i];
            $detail->save();
  
           } 
           
  
           $response = [];
           if($produk){
             $response = [
                 'message' => 'Berhasil ',
                 'data'    => $produk,
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

    public function delete_produk(Request $request , $id){
      $produk         = Produk::where('id',$id)->get();
      $data['nama']   = $produk[0]['nama'];
      $data['path']   = 'public/produk';
      $data['images'] = $produk[0]['images'];

      $move   = new Images();
      $action = $move->DeletePath($data);
      $del    = Produk::Where('id' , $id)->delete();
      $response = [];
      if($produk){
        $response = [
            'message' => 'Berhasil ',
            'data'    => $del,
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
