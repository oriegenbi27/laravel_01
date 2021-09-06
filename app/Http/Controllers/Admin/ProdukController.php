<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Config;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use App\Library\SendToApi ;
use App\Produk;
use App\SubJenis;
use App\Library\Images ;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Validator;
use DataTables;
use Yajra\DataTables\Html\Builder;

class ProdukController extends Controller
{

  protected $htmlBuilder;

  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }


  public function index(Request $request){

  if($request->ajax()){ 
   

    $crud = new SendToApi(); 
    $url = '/api/DataProduk/?start='.$request->input('start').'&length='.$request->input('length').'&draw='.$request->input('draw').'&serch='.$request->input('search')['value'].'&order='.$request->input('order')[0]['column'].'&dir='.$request->input('order')[0]['dir'].'&rank='.$request->input('s');
    $method = 'GET';
    $route = 'Erp Produk';
    $data = NULL;
    $produk = $crud->crud($url , $method , $data);
    $DataTables = [];
    
    foreach($produk->data as $row){
      $edit=base64_encode("modif::".$row->id);
      $delete=base64_encode("trans::".$row->id);
      $DataTables[]=array(
        "date"             => $row->updated_at,
        "images"           => '<img alt="image" class="rounded-circle" width="64" height="64" src="'.Config::get('constant.endpoint.url').'/storage/produk/'.$row->images.'">',
        "nama"             => $row->nama,
        "harga"            => "Rp ".number_format($row->harga),
        "berat"            => $row->berat,
        "stock"            => $row->stock,
        "diskon"           => $row->diskon."%", 
        "totalharga"       => "Rp.".number_format($row->total_harga),
        "ppn"           => $row->ppn."%",
        "jenisbarang"      => (isset($row->jenisbarang[0]->nama)?$row->jenisbarang[0]->nama:''),
        "brand"            => (isset($row->brand[0]->nama)?$row->brand[0]->nama:''),
        "subjenis"         => (isset($row->brand[0]->nama)?$row->brand[0]->nama:''),
        "Action"           => '<a href="/produk/edit?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>
                               <a href="/produk/delete?code='.$delete.'" class="btn btn-outline btn-link"><i class="fa fa-trash" ></i> Non Active</a>',
      );
    } 
    
      return response()->json([
        "draw"  => intval($request->input('draw')),
        "recordsTotal" => $produk->count,
        "recordsFiltered" => $produk->count,
        "data"  => $DataTables
      ]);

    };
    $html = $this->htmlBuilder
      ->addColumn(['data' => 'date',               'name' => 'date',       'title' => 'Date'])
      ->addColumn(['data' => 'images',             'name' => 'images',     'title' => 'Images','width'=>'10%','orderable'=>false])
      ->addColumn(['data' => 'nama',               'name' => 'nama',       'title' => 'Nama'])
      ->addColumn(['data' => 'harga',              'name' => 'harga',      'title' => 'Harga Dasar'])
      ->addColumn(['data' => 'berat',              'name' => 'berat',      'title' => 'Berat'])
      ->addColumn(['data' => 'stock',              'name' => 'stock',      'title' => 'Stock'])
      ->addColumn(['data' => 'diskon',             'name' => 'diskon',     'title' => 'Diskon'])
      ->addColumn(['data' => 'totalharga',         'name' => 'totalharga', 'title' => 'Harga Jual'])
      ->addColumn(['data' => 'ppn',                'name' => 'ppn',        'title' => 'PPn'])
      ->addColumn(['data' => 'jenisbarang',        'name' => 'jenisbarang','title' => 'jenisbarang'])
      ->addColumn(['data' => 'brand',              'name' => 'brand',      'title' => 'Brand'])
      ->addColumn(['data' => 'subjenis',           'name' => 'subjenis',   'title' => 'subjenis'])
      ->addColumn(['data' => 'Action' ,            'name' => 'action' ,    'title' => 'Action','ordertable' => false])
      ->parameters([
        'responsive'  => true,
        'dom'         => '<"html5buttons"B>lTfgtip',
        'order'       => [0, 'desc'],
        'buttons'     =>  [

          
          
          ['className'=>'btn btn-primary btn-outline','titleAttr'=>'Tambah ','text'=>'<i class="fa fa-sliders" aria-hidden="true"></i>',
              'init'=>'function(api, node, config) {
              $(node).removeClass(\'dt-button\')
                }',
                'action'=>'function ( e, dt, node, config ){
                  window.location.href="/produk/add";
                }'
          ],
         
              [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
      ],
      ]);
    
      $jenis_crud = new SendToApi();
      $jenis_url = '/api/GetDataJenisBarang';
      $jenis_method = 'GET';
      $jenis_data = NULL;
      $jenis_produk = $jenis_crud->crud($jenis_url , $jenis_method , $jenis_data);
      // dd($jenis_produk);

    return view('admin.Produk.produk' , compact('html') , ['jenis' => $jenis_produk]);


   }

   public function jsonproduk(Request $request){



    $crud = new SendToApi();
    $url = '/api/GetDataProduk';
    $method = 'GET';
    $route = 'Erp Produk';
    $data = NULL;
    $produk = $crud->crud($url , $method , $data);
    
    
    foreach($produk->data as $a){
        $data[]=array(
            
            $a->id,
            $a->nama,
            $a->brand_id,
            $a->berat,
            $a->unit,
            $a->harga,
            );
            
    }
    
    $callback = array(
                'role'=>'',
                'draw' =>'',
                'recordsTotal'=>sizeof($data),
                'recordsFiltered'=>sizeof($data),
                'data'=>$data
            );
    header('Content-Type: application/json');
    echo json_encode($callback);



   }

  public function add_produk(Request $request){

    if($request->isMethod('GET')){
      $brand_crud = new SendToApi();
      $brand_url = '/api/GetDataBrand';
      $brand_method = 'GET';
      $brand_data = NULL;
      $brand_produk = $brand_crud->crud($brand_url , $brand_method , $brand_data);

      $subjenis_crud = new SendToApi();
      $subjenis_url = '/api/GetDataSubJenis';
      $subjenis_method = 'GET';
      $subjenis_data = NULL;
      $subjenis_produk = $subjenis_crud->crud($subjenis_url , $subjenis_method , $subjenis_data);

      $jenis_crud = new SendToApi();
      $jenis_url = '/api/GetDataJenisBarang';
      $jenis_method = 'GET';
      $jenis_data = NULL;
      $jenis_produk = $jenis_crud->crud($jenis_url , $jenis_method , $jenis_data);

      $satuan_crud = new SendToApi();
      $satuan_url = '/api/GetDataSatuan';
      $satuan_method = 'GET';
      $satuan_data = NULL;
      $satuan_produk = $satuan_crud->crud($satuan_url , $satuan_method , $satuan_data);
      return view('admin.Produk.produkAdd' , ['brand' => $brand_produk , 'jenis' => $jenis_produk, 'subjenis' => $subjenis_produk, 'satuan' => $satuan_produk]);
    }else{
      $request->validate([
                          'nama'               => 'required',
                          // 'brand_id'           => 'required',
                          // 'jenis_barang_id'    => 'required',
                          // 'sub_jenis_barang_id'    => 'required',
                          'harga'              => 'required',
                          'berat'              => 'required',
                          'diskon'             => 'required',
                          'stock'              => 'required',
                          'unit'               => 'required',
                          'images'             => 'required',
                          // 'idkom'              => 'required'
      ], [
        '*.required' => 'data tidak boleh kosong',
      ]);

      $images_lib     = new Images();
      $images_filter  = $images_lib->ImagesFilter($request->file('images'));
      // $data2 = [
      //   'idkom'                 => $request->get('idkom')
      // ];
      $data = [
        $images_filter,
        ['name' => 'code',                  'contents' => $request->get('code')],
        ['name' => 'nama',                  'contents' => $request->get('nama')],
        ['name' => 'brand_id',              'contents' => $request->get('brand_id')],
        ['name' => 'jenis_barang_id',       'contents' => $request->get('jenis_barang_id')],
        ['name' => 'sub_jenis_barang_id',   'contents' => $request->get('sub_jenis_barang_id')],
        ['name' => 'harga',                 'contents' => $request->get('harga')],
        ['name' => 'berat',                 'contents' => $request->get('berat')],
        ['name' => 'diskon',                'contents' => $request->get('diskon')],
        ['name' => 'stock',                 'contents' => $request->get('stock')],
        ['name' => 'unit',                  'contents' => $request->get('unit')],
        ['name' => 'totalharga',            'contents' => $request->get('totalharga')],
        ['name' => 'ppn',                   'contents' => $request->get('ppn')],
        ['name' => 'idkom',                 'contents' => json_encode($request->get('idkom'))],
        ['name' => 'namakom',               'contents' => json_encode($request->get('namakom'))],
        ['name' => 'qtykom',                'contents' => json_encode($request->get('qtykom'))],
        ['name' => 'satuankom',             'contents' => json_encode($request->get('satuankom'))],

      ];



      $url    = '/api/add_produk/';
      $method = 'POST';
      $type   = 'multipart';
      $route  = 'List Produk';
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data , $type);

      // dd($action);
      if ($action->code=="000") { 
        return Redirect::Route($route)->with('success', Alert::toast('Berhasil', 'success'));
      }else{
        return Redirect::Route($route)->with('error', Alert::toast('Gagal', 'error'));
      }
    }

  }

  public function edit_produk(Request $request){
  $decode = base64_decode($request->get('code'));
  $exp  = explode('::',$decode);
  $id   = $exp[1];
  if($request->isMethod('GET')){
    $url = '/api/find_produk/'.$id;
    $method = 'GET';
    $data = NULL;
    $crud = new SendToApi();
    $data = $crud->crud($url,$method ,$data);




    $brand_crud = new SendToApi();
    $brand_url = '/api/GetDataBrand';
    $brand_method = 'GET';
    $brand_data = NULL;
    $brand_produk = $brand_crud->crud($brand_url , $brand_method , $brand_data);

    $jenis_crud = new SendToApi();
    $jenis_url = '/api/GetDataJenisBarang';
    $jenis_method = 'GET';
    $jenis_data = NULL;
    $jenis_produk = $jenis_crud->crud($jenis_url , $jenis_method , $jenis_data);

    $subjenis_crud = new SendToApi();
    $subjenis_url = '/api/GetDataSubJenis';
    $subjenis_method = 'GET';
    $subjenis_data = NULL;
    $subjenis_produk = $jenis_crud->crud($subjenis_url , $subjenis_method , $subjenis_data);

    $satuan_crud = new SendToApi();
    $satuan_url = '/api/GetDataSatuan';
    $satuan_method = 'GET';
    $satuan_data = NULL;
    $satuan_produk = $satuan_crud->crud($satuan_url , $satuan_method , $satuan_data);

    return view('admin.Produk.produkEdit' , ['produk' => $data , 'brand' => $brand_produk , 'jenis' => $jenis_produk, 'subjenis' => $subjenis_produk, 'satuan' => $satuan_produk]);
    }else{

      // $request->validate([
      //   'id'                 => 'required',
      //   'nama'               => 'required',
      //   'brand_id'           => 'required',
      //   'jenis_barang_id'    => 'required',
      //   'sub_jenis_barang_id'    => 'required',
      //   'harga'              => 'required',
      //   'berat'              => 'required',
      //   'diskon'             => 'required',
      //   'stock'              => 'required',
      //   'unit'               => 'required',
      //   'images'             => 'required'
      //   ], [
      //   '*.required' => 'data tidak boleh kosong',
      //   ]);

        $images_lib     = new Images();
        $images_filter  = $images_lib->ImagesFilter($request->file('images'));
        $data = [
        $images_filter,
        ['name' => 'id',              'contents' => $request->get('id')],
        ['name' => 'nama',            'contents' => $request->get('nama')],
        ['name' => 'brand_id',        'contents' => $request->get('brand_id')],
        ['name' => 'jenis_barang_id', 'contents' => $request->get('jenis_barang_id')],
        ['name' => 'sub_jenis_barang_id', 'contents' => $request->get('sub_jenis_barang_id')],
        ['name' => 'harga',           'contents' => $request->get('harga')],
        ['name' => 'berat',           'contents' => $request->get('berat')],
        ['name' => 'diskon',          'contents' => $request->get('diskon')],
        ['name' => 'stock',           'contents' => $request->get('stock')],
        ['name' => 'unit',            'contents' => $request->get('unit')],
        ['name' => 'totalharga',            'contents' => $request->get('totalharga')],
        ['name' => 'ppn',                   'contents' => $request->get('ppn')],
        ['name' => 'idkom',                 'contents' => json_encode($request->get('idkom'))],
        ['name' => 'namakom',               'contents' => json_encode($request->get('namakom'))],
        ['name' => 'qtykom',                'contents' => json_encode($request->get('qtykom'))],
        ['name' => 'satuankom',             'contents' => json_encode($request->get('satuankom'))],

        ];

        $url    = '/api/edit_produk/'.$id;
        $method = 'POST';
        $type   = 'multipart';
        $route  = 'List Produk';
        $crud   = new SendToApi();
        $action = $crud->crud($url , $method , $data , $type);
        // dd($action);
        if ($action->code=="000") { 
          return Redirect::Route($route)->with('success', Alert::toast('Berhasil', 'success'));
        }else{
          return Redirect::Route($route)->with('error', Alert::toast('Gagal', 'error'));
        }
    }

  }

  public function delete_produk(Request $request){

    $data = [
      'id'  => base64_decode($request->get('id'))
    ];
    $url    = '/api/delete_produk/'.$id;
    $method = 'GET';
    $route  = 'List Produk';
    $crud   = new SendToApi();
    $action = $crud->crud($url , $method , $data);
    dd($action);
    return Redirect::route($route) ;
  }

}
