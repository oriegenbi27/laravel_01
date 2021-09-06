<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:api')->get('/customer', function (Request $request) {
//   return $request->customer();
// });

Route::group(['prefix' => 'payment'], function () {
    Route::match(['GET', 'POST'],'', ['uses' => 'PaymentController@notification']);
});



Route::post('login', ['uses' => 'APi\UserController@login']);

Route::match(['GET', 'POST'], 'me', ['uses' => 'APi\UserController@me']);
Route::get('verification/{token}', ['as' => 'user-verification', 'uses' => 'APi\UserController@userVerification']);
Route::post('register', ['uses' => 'APi\UserController@register']);

Route::group(['prefix' => 'karyawan'], function () {
    Route::match(['GET', 'POST'],'/', ['uses' => 'APi\UserController@karyawan']);
    Route::post('privilage', ['uses' => 'APi\UserController@privilage']);
    Route::get('find/{id}', ['uses' => 'APi\UserController@Findkaryawanid']);
});


// Route::match(['GET', 'POST', 'DELETE'], 'Customer', ['uses' => 'APi\CustomerController@add_customer']);

// Customer
Route::post('add_customer', ['uses' => 'APi\CustomerController@add_customer']);
Route::get('GetDataCustomer', ['uses' => 'APi\CustomerController@GetDataCustomer']);
Route::get('DataCustomer', ['uses' => 'APi\CustomerController@DataCustomer']);
Route::post('edit_customer/{id}', ['uses' => 'APi\CustomerController@edit_customer']);
Route::get('find_customer/{id}' , ['uses'=> 'APi\CustomerController@find_customer']);
Route::post('delete_customer' , ['uses'=> 'APi\CustomerController@delete_customer']);

// Supplier
Route::post('add_supplier', ['uses' => 'APi\SupplierController@add_supplier']);
Route::get('GetDataSupplier', ['uses' => 'APi\SupplierController@GetDataSupplier']);
Route::post('edit_supplier/{id}', ['uses' => 'APi\SupplierController@edit_supplier']);
Route::get('find_supplier/{id}' , ['uses'=> 'APi\SupplierController@find_supplier']);
Route::get('delete_supplier/{id}' , ['uses'=> 'APi\SupplierController@delete_supplier']);

// produkk
Route::post('add_produk', ['uses' => 'APi\ProdukController@add_produk']);
Route::get('GetDataProduk' , ['uses' => 'APi\ProdukController@GetDataProduk'] );
Route::get('DataProduk' , ['uses' => 'APi\ProdukController@DataProduk'] );
Route::post('edit_produk/{id}', ['uses' => 'APi\ProdukController@edit_produk']);
Route::GET('delete_produk/{id}', ['uses' => 'APi\ProdukController@delete_produk']);
Route::GET('find_produk/{id}', ['uses' => 'APi\ProdukController@find_produk']);

// brand
Route::post('add_brand', ['uses' => 'APi\BrandController@add_brand']);
Route::get('GetDataBrand' , ['uses' => 'APi\BrandController@GetDatabrand'] );
Route::post('edit_brand/{id}', ['uses' => 'APi\BrandController@edit_brand']);
Route::post('delete_brand/{id}', ['uses' => 'APi\BrandController@delete_brand']);
Route::get('find_brand/{id}' , ['uses'=> 'APi\BrandController@find_brand']);

// bank
Route::get('GetDataBank' , ['uses' => 'APi\BankController@GetDataBank'] );
Route::post('add_bank', ['uses' => 'APi\BankController@add_bank']);
Route::post('edit_bank/{id}', ['uses' => 'APi\BankController@edit_bank']);
Route::get('find_bank/{id}' , ['uses'=> 'APi\BankController@find_bank']);
Route::get('delete_bank/{id}', ['uses' => 'APi\BankController@delete_bank']);

// satuan
Route::post('add_satuan', ['uses' => 'APi\SatuanController@add_satuan']);
Route::get('GetDataSatuan' , ['uses' => 'APi\SatuanController@GetDatasatuan'] );
Route::match(['POST'],'edit_satuan/{id}', ['uses' => 'APi\SatuanController@edit_satuan']);
Route::get('delete_satuan/{id}', ['uses' => 'APi\SatuanController@delete_satuan']);
Route::get('find_satuan/{id}' , ['uses'=> 'APi\SatuanController@find_satuan']);

// jenis_barang
Route::post('add_jenis_barang', ['uses' => 'APi\JenisBarangController@add_jenis_barang']);
Route::get('GetDataJenisBarang' , ['uses' => 'APi\JenisBarangController@GetDataJenisBarang'] );
Route::match(['POST'],'edit_jenis_barang/{id}', ['uses' => 'APi\JenisBarangController@edit_jenis_barang']);
Route::get('delete_jenis_barang/{id}', ['uses' => 'APi\JenisBarangController@delete_jenis_barang']);
Route::get('find_jenis_barang/{id}' , ['uses'=> 'APi\JenisBarangController@find_jenis_barang']);

// Sub Jenis
Route::post('add_sub_jenis', ['uses' => 'APi\SubJenisController@add_sub_jenis']);
Route::get('GetDataSubJenis' , ['uses' => 'APi\SubJenisController@GetDataSubJenis'] );
Route::match(['POST'],'edit_sub_jenis/{id}', ['uses' => 'APi\SubJenisController@edit_sub_jenis']);
Route::get('delete_sub_jenis/{id}', ['uses' => 'APi\SubJenisController@delete_sub_jenis']);
Route::get('find_sub_jenis/{id}' , ['uses'=> 'APi\SubJenisController@find_sub_jenis']);

// Varian
Route::post('add_varian', ['uses' => 'APi\VarianController@add_varian']);
Route::get('GetDataVarian' , ['uses' => 'APi\VarianController@GetDatavarian'] );
Route::match(['POST'],'edit_varian/{id}', ['uses' => 'APi\VarianController@edit_varian']);
Route::get('delete_varian/{id}', ['uses' => 'APi\VarianController@delete_varian']);
Route::get('find_varian/{id}' , ['uses'=> 'APi\VarianController@find_varian']);

// group customer
Route::post('add_group_customer', ['uses' => 'APi\GroupCustomerController@add_group_customer']);
Route::get('GetDataGroupCustomer' , ['uses' => 'APi\GroupCustomerController@GetDataGroupCustomer'] );
Route::match(['POST'],'edit_group_customer/{id}', ['uses' => 'APi\GroupCustomerController@edit_group_customer']);
Route::get('delete_group_customer/{id}', ['uses' => 'APi\GroupCustomerController@delete_group_customer']);
Route::get('find_group_customer/{id}' , ['uses'=> 'APi\GroupCustomerController@find_group_customer']);

// sumber sales
Route::post('add_sumber_sales', ['uses' => 'APi\SumberSalesController@add_sumber_sales']);
Route::get('GetDataSumberSales' , ['uses' => 'APi\SumberSalesController@GetDataSumberSales'] );
Route::match(['POST'],'edit_sumber_sales/{id}', ['uses' => 'APi\SumberSalesController@edit_sumber_sales']);
Route::get('delete_sumber_sales/{id}', ['uses' => 'APi\SumberSalesController@delete_sumber_sales']);
Route::get('find_sumber_sales/{id}' , ['uses'=> 'APi\SumberSalesController@find_sumber_sales']);

// Order Input
Route::post('add_order_input', ['uses' => 'APi\OrderInputController@add_order_input']);
Route::get('GetDataOrderInput' , ['uses' => 'APi\OrderInputController@GetDataOrderInput'] );
Route::match(['POST'],'edit_order_input/{id}', ['uses' => 'APi\OrderInputController@edit_order_input']);
Route::get('delete_order_input/{id}', ['uses' => 'APi\OrderInputController@delete_order_input']);
Route::get('find_order_input/{id}' , ['uses'=> 'APi\OrderInputController@find_order_input']);
Route::get('find_detail_order/{id}' , ['uses'=> 'APi\OrderInputController@find_detail_order']);

// Purchasing
Route::post('add_purchasing', ['uses' => 'APi\PurchasingController@add_purchasing']);
Route::get('GetDataPurchasing' , ['uses' => 'APi\PurchasingController@GetDataPurchasing'] );
Route::match(['POST'],'edit_purchasing/{id}', ['uses' => 'APi\PurchasingController@edit_purchasing']);
Route::match(['POST'],'detail_purchasing/{id}', ['uses' => 'APi\PurchasingController@detail_purchasing']);
Route::match(['POST'],'edit_tglkirim/{id}', ['uses' => 'APi\PurchasingController@edit_tglkirim']);
Route::get('delete_purchasing/{id}', ['uses' => 'APi\PurchasingController@delete_purchasing']);
Route::get('find_purchasing/{id}' , ['uses'=> 'APi\PurchasingController@find_purchasing']);
Route::match(['POST' , 'GET'] , 'purchasing_cetak/{id}', ['uses' => 'APi\PurchasingController@purchasing_cetak']);
Route::get('GetDataPurchasingOldest' , ['uses' => 'APi\PurchasingController@GetDataPurchasingOldest'] );
Route::match(['POST'],'bayar_purchasing/{id}', ['uses' => 'APi\PurchasingController@bayar_purchasing']);

// Return
Route::post('add_return', ['uses' => 'APi\ReturnController@add_return']);



// Setting Dashboard
Route::group(['prefix' => 'setting'], function () {
	Route::post('setting_dashboard', ['uses' => 'APi\SettingController@setting_dashboard']);
	Route::get('GetDataSetting', ['uses' => 'APi\SettingController@GetDataSetting']);
	Route::match(['GET', 'POST'],'preferensi', ['uses' => 'APi\SettingController@preferensi']);
});

// level
Route::get('GetDataLevel/{id}', ['uses' => 'APi\LevelController@GetDataLevel']);
Route::match(['POST' , 'GET'] , 'hak_akses/{id}', ['uses' => 'APi\LevelController@add_data']);
Route::match(['POST' , 'GET'] , 'add_data_batch/{id}', ['uses' => 'APi\LevelController@add_data_batch']);

// Jabatan
Route::get('GetDataJabatan', ['uses' => 'APi\JabatanController@GetDataJabatan']);
Route::get('find_jabatan/{id}', ['uses' => 'APi\JabatanController@find_jabatan']);
Route::get('GetDataDetailJabatan', ['uses' => 'APi\JabatanController@GetDataDetailJabatan']);
Route::POST('AddJabatan', ['uses' => 'APi\JabatanController@AddJabatan']);
Route::POST('EditJabatan', ['uses' => 'APi\JabatanController@EditJabatan']);
Route::GET('DeleteJabatan/{id}', ['uses' => 'APi\JabatanController@DeleteJabatan']);


// Pos
Route::get('GetDataDetailTmpPos', ['uses' => 'APi\TmpPosController@GetDataDetailTmpPos']);
Route::match(['POST'] , 'add_tmp_pos', ['uses' => 'APi\TmpPosController@add_tmp_pos']);
Route::match(['POST'] , 'edit_tmp_pos', ['uses' => 'APi\TmpPosController@edit_tmp_pos']);
Route::get('find_tmp_pos/{id}', ['uses' => 'APi\TmpPosController@find_tmp_pos']);
Route::get('find_tmp_pos_produk/{id}', ['uses' => 'APi\TmpPosController@find_tmp_pos_produk']);
Route::match(['POST'] , 'cetak_pos', ['uses' => 'APi\TmpPosController@cetak_pos']);
// PosDetail
Route::match(['POST'] , 'pos/CreateDetail', ['uses' => 'APi\PosController@CreateDetail']);
 

// Menu
Route::match(['GET' , 'POST'] , '/GetDataMenu/{id}', ['uses' => 'APi\MenuController@GetDataMenu']);

// Warehouse
Route::post('add_warehouse', ['uses' => 'APi\WarehouseController@add_warehouse']);
Route::match(['GET' , 'POST'] ,'find_ponomor/{id}' , ['uses'=> 'APi\WarehouseController@find_ponomor']);


Route::group(['prefix' => 'kasir'], function () {
    Route::match(['GET', 'POST'],'carting', ['uses' => 'APi\KasirController@Carting']);
    Route::post('cartingpayment', ['uses' => 'APi\KasirController@payment']);
    Route::get('penjualan', ['uses' => 'APi\KasirController@penjualan']);
});

// Bundling
Route::group(['prefix' => 'bundling'], function () {
    Route::get('DataBundling' , ['uses' => 'APi\BundlingController@DataBundling'] );
    Route::get('GetDataBundling' , ['uses' => 'APi\BundlingController@GetDataBundling'] );
    Route::post('add_bundling', ['uses' => 'APi\BundlingController@add_bundling']);
   
});
// Outlet
Route::group(['prefix' => 'outlet'], function () {
    Route::get('DataOutlet' , ['uses' => 'APi\OutletController@DataOutlet'] );
    Route::get('GetDataOutlet' , ['uses' => 'APi\OutletController@GetDataOutlet'] );
    Route::post('add_outlet', ['uses' => 'APi\OutletController@add_outlet']);
    Route::match(['POST'],'edit_outlet/{id}', ['uses' => 'APi\OutletController@edit_outlet']);
    Route::get('find_outlet/{id}' , ['uses'=> 'APi\OutletController@find_outlet']);
    Route::post('delete_outlet' , ['uses'=> 'APi\OutletController@delete_outlet']);
   
});
