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
use App\Promo;
use App\Library\Images ;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Validator;
use DataTables;
use Yajra\DataTables\Html\Builder;

class PromoController extends Controller
{

  protected $htmlBuilder;

  public function __construct(Builder $htmlBuilder)
  {
    $this->htmlBuilder = $htmlBuilder;
  }


  public function index(Request $request){

  if($request->ajax()){ 
   

    $crud = new SendToApi(); 
    $url = '/api/promo/DataPromo/?start='.$request->input('start').'&length='.$request->input('length').'&draw='.$request->input('draw').'&serch='.$request->input('search')['value'].'&order='.$request->input('order')[0]['column'].'&dir='.$request->input('order')[0]['dir'];
    $method = 'GET';
    $route = 'List Promo';
    $data = NULL;
    $promo = $crud->crud($url , $method , $data);
    $DataTables = [];
    
    foreach($promo->data as $row){
      $edit=base64_encode("modif::".$row->id);
      $delete=base64_encode("trans::".$row->id);
      $DataTables[]=array(
        "date"             => $row->updated_at,
        "images"           => '<img alt="image" class="rounded-circle" width="64" height="64" src="'.Config::get('constant.endpoint.url').'/storage/produk/'.$row->gambar.'">',
        "judul"            => $row->judul,
        "harga"            => "Rp ".number_format($row->harga),
        "tgl_awal"         => $row->tgl_awal,
        "tgl_akhir"        => $row->tgl_akhir,
        "gratis"           => (isset($row->gratis[0]->nama)?$row->gratis[0]->nama:''),
        "Action"           => '<a href="/produk/edit?code='.$edit.'" class="btn btn-outline btn-link"><i class="fa fa-edit" ></i> Edit</a>
                               <a href="/produk/delete?code='.$delete.'" class="btn btn-outline btn-link"><i class="fa fa-trash" ></i> Non Active</a>',
      );
    } 
    
      return response()->json([
        "draw"  => intval($request->input('draw')),
        "recordsTotal" => $promo->count,
        "recordsFiltered" => $promo->count,
        "data"  => $DataTables
      ]);

    };
    $html = $this->htmlBuilder
      ->addColumn(['data' => 'date',               'name' => 'date',       'title' => 'Date'])
      ->addColumn(['data' => 'images',             'name' => 'images',     'title' => 'Images','width'=>'10%','orderable'=>false])
      ->addColumn(['data' => 'judul',              'name' => 'judul',      'title' => 'Judul'])
      ->addColumn(['data' => 'harga',              'name' => 'harga',      'title' => 'Harga'])
      ->addColumn(['data' => 'gratis',             'name' => 'gratis',     'title' => 'Gratis'])
      ->addColumn(['data' => 'tgl_awal',           'name' => 'tgl_awal',   'title' => 'Tanggal awal'])
      ->addColumn(['data' => 'tgl_akhir',          'name' => 'tgl_akhir',  'title' => 'Tanggal akhir'])
      
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
                  window.location.href="promo/add";
                }' 
          ],
         
              [ 'extend'=> 'copy', 'className'=>'btn btn-primary btn-outline','titleAttr'=>'Copy Data' ,'text'=> '<i class="fa fa-clone" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'csv', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Save To CSV','text'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
              [ 'extend'=>'print', 'className'=>'btn btn-primary  btn-outline','titleAttr'=>'Print Data','text'=>'<i class="fa fa-print" aria-hidden="true"></i>','init'=>' function(api, node, config) { $(node).removeClass(\'dt-button\')}'],
      ],
      ]);
 
    return view('admin.Promo.promo' , compact('html'));


   }

  //  Add Promo
  public function add_promo(Request $request){
    if ($request->isMethod('GET')) {
          return view('admin.Promo.promoAdd');
    }else{
      $request->validate([
                          'code'               => 'required',
                          'judul'              => 'required',
                          'ket'                => 'required',
                          'item'               => 'required',
                          'minbeli'            => 'required',
                          'harga'              => 'required',
                          'tbonus'             => 'required',
                          'awal'               => 'required',
                          'akhir'              => 'required',
                          
      ], [
        '*.required' => 'data tidak boleh kosong',
      ]);

      $images_lib     = new Images();
      $images_filter  = $images_lib->ImagesFilter($request->file('images'));
      
      $data = [
        $images_filter,
        ['name' => 'code',                  'contents' => $request->get('code')],
        ['name' => 'judul',                 'contents' => $request->get('judul')],
        ['name' => 'ket',                   'contents' => $request->get('ket')],
        ['name' => 'item',                  'contents' => $request->get('item')],
        ['name' => 'minbeli',               'contents' => $request->get('minbeli')],
        ['name' => 'harga',                 'contents' => $request->get('harga')],
        ['name' => 'tbonus',                'contents' => $request->get('tbonus')],
        ['name' => 'diskon',                'contents' => $request->get('diskon')],
        ['name' => 'fitem',                 'contents' => $request->get('fitem')],
        ['name' => 'awal',                  'contents' => $request->get('awal')],
        ['name' => 'akhir',                 'contents' => $request->get('akhir')],
       

      ];



      $url    = '/api/promo/add_promo/';
      $method = 'POST';
      $type   = 'multipart';
      $route  = 'List Produk';
      $crud   = new SendToApi();
      $action = $crud->crud($url , $method , $data , $type);

      dd($action);
      return Redirect::route($route);
    }

  }

}
