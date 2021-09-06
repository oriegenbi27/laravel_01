<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::match(['GET', 'POST'], '/', ['uses' => 'Admin\UserController@login', 'as' => 'Erp Login']);
Route::match(['GET', 'POST'], '/register', ['uses' => 'Admin\UserController@register' , 'as' => 'Erp Register']);
Route::get('/home', ['uses' => 'Admin\AdminController@home', 'as' => 'Web Sys']);
Route::match(['GET', 'POST'], '/flush', ['uses' => 'Admin\AdminController@flush', 'as' => 'admin flush']);

Route::match(['GET','POST'], '/purchasing_cetak/{id}' ,['uses' => 'Admin\PurchasingController@purchasing_cetak' , 'as' => 'Purchasing Cetak']);


Route::group(['middleware' => ['AuthSession']], function () {

  // customer
  Route::group(['prefix' => 'customer'], function(){ 
    Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\CustomerController@index' , 'as' => 'Erp Customer']);
    Route::match(['GET' , 'POST'] , 'add' , ['uses' => 'Admin\CustomerController@add_customer' , 'as' => 'Erp Add Customer']);
    Route::match(['GET' ,'POST'] , 'edit' , ['uses' => 'Admin\CustomerController@edit_customer' , 'as' => 'Erp Edit Customer']);
    Route::match(['GET' , 'POST'] ,'delete', ['uses' => 'Admin\CustomerController@delete_customer' , 'as' => 'Erp Delete Customer']);
    Route::get('/GetDataCustomer' , ['uses' => 'Admin\CustomerController@GetDataCustomer' , 'as' => 'Erp Data Customer']);
  });


  // supplier
  Route::group(['prefix' => 'supplier'], function(){ 
    Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\SupplierController@index' , 'as' => 'Erp Supplier']);
    Route::match(['GET'] , 'jsonsupplier' , ['uses' => 'Admin\SupplierController@jsonsupplier', 'as' => 'jsonsupplier']);
    Route::match(['GET' , 'POST'] , 'add' , ['uses' => 'Admin\SupplierController@add_supplier' , 'as' => 'Erp Add Supplier']);
    Route::match(['GET' ,'POST'] , '/edit' , ['uses' => 'Admin\SupplierController@edit_supplier' , 'as' => 'Erp Edit Supplier']);
    Route::get('delete', ['uses' => 'Admin\SupplierController@delete_supplier' , 'as' => 'Erp Delete Supplier']);
    Route::get('GetDataSupplier' , ['uses' => 'Admin\SupplierController@GetDataSupplier' , 'as' => 'Erp Data Supplier']);
  });

  // Brand
  Route::group(['prefix' => 'brand'], function(){ 
    Route::match(['GET', 'POST'] , '/' , ['uses' => 'Admin\BrandController@index', 'as' => 'List Brand' ]);
    Route::match(['GET','POST'], 'add' , ['uses' => 'Admin\BrandController@add_brand' , 'as' => 'Add Brand']);
    Route::get('/find_brand/{id}' , ['uses' => 'Admin\BrandController@find_brand' ,'as' => 'Find Brand']);
    Route::match(['GET' , 'POST'] , 'edit' , ['uses' => 'Admin\BrandController@edit_brand', 'as' => 'Edit Brand' ]);
    Route::match(['GET' , 'POST'] , 'delete' , ['uses' => 'Admin\BrandController@delete_brand', 'as' => 'Delete Brand' ]);
  }); 

  // Bank
  Route::group(['prefix' => 'bank'], function(){ 
    Route::match(['GET'] , '/' , ['uses' => 'Admin\BankController@index' , 'as' => 'Erp Bank']);
    Route::match(['GET' , 'POST'] , 'add' , ['uses' => 'Admin\BankController@add_bank' , 'as' => 'Erp Add Bank']);
    Route::match(['GET' ,'POST'] , 'edit' , ['uses' => 'Admin\BankController@edit_bank' , 'as' => 'Erp Edit Bank']);
    Route::get('delete_bank', ['uses' => 'Admin\BankController@delete_bank' , 'as' => 'Erp Delete Bank']);
  });

  // Produk
  Route::group(['prefix' => 'produk'], function(){ 
    Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\ProdukController@index', 'as' => 'List Produk']);
    Route::match(['GET'] , '/jsonproduk' , ['uses' => 'Admin\ProdukController@jsonproduk', 'as' => 'jsonproduk']);
    Route::match(['GET' , 'POST'] , 'add' , ['uses' => 'Admin\ProdukController@add_produk' , 'as' => 'Add Produk']);
    Route::match(['GET' , 'POST'] , 'edit' , ['uses' => 'Admin\ProdukController@edit_produk' , 'as' => 'Edit Produk']);
    Route::get('/find_produk/{id}' , ['uses' => 'Admin\ProdukController@find_produk' ,'as' => 'Find produk']);
    Route::get('delete' , ['uses' => 'Admin\ProdukController@delete_produk' ,'as' => 'Delete produk']);
  });
    // Satuan
  Route::group(['prefix' => 'satuan'], function(){ 
    Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\SatuanController@index', 'as' => 'List Satuan']);
    Route::match(['GET','POST'], 'add' , ['uses' => 'Admin\SatuanController@add_satuan' , 'as' => 'Add Satuan']);
    Route::match(['GET','POST'], 'edit' , ['uses' => 'Admin\SatuanController@edit_satuan' , 'as' => 'Edit Satuan']);
    Route::get('/find_satuan/{id}' , ['uses' => 'Admin\SatuanController@find_satuan' ,'as' => 'Find Satuan']);
    Route::get('delete-satuan' , ['uses' => 'Admin\SatuanController@delete_satuan' ,'as' => 'Delete Satuan']);
 });
    // Varian
    Route::group(['prefix' => 'varian'], function(){ 
    Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\VarianController@index', 'as' => 'List Varian' ]);
    Route::match(['GET','POST'], 'add' , ['uses' => 'Admin\VarianController@add_varian' , 'as' => 'Add Varian']);
    Route::match(['GET','POST'], 'edit' , ['uses' => 'Admin\VarianController@edit_varian' , 'as' => 'Edit Varian']);
    Route::get('/find_varian/{id}' , ['uses' => 'Admin\VarianController@find_varian' ,'as' => 'Find Varian']);
    Route::get('delete' , ['uses' => 'Admin\VarianController@delete_varian' ,'as' => 'Delete Varian']);
  });

  Route::group(['prefix' => 'jenis-barang'], function(){ 
    // Jenis Barang
    Route::match(['GET'] , '/' , ['uses' => 'Admin\JenisBarangController@index' , 'as' => 'List Jenis Barang']);
    Route::match(['GET','POST'], 'add' , ['uses' => 'Admin\JenisBarangController@add_jenis_barang' , 'as' => 'Add Jenis Barang']);
    Route::match(['GET','POST'], 'edit' , ['uses' => 'Admin\JenisBarangController@edit_jenis_barang' , 'as' => 'Edit Jenis Barang']);
    Route::get('/find_jenis_barang/{id}' , ['uses' => 'Admin\JenisBarangController@find_jenis_barang' ,'as' => 'Find Jenis Barang']);
    Route::get('delete' , ['uses' => 'Admin\JenisBarangController@delete_jenis_barang' ,'as' => 'Delete Jenis Barang']);
  });

    // Sub Jenis
  Route::group(['prefix' => 'sub-jenis'], function(){ 
    Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\SubJenisController@index' , 'as' => 'List Sub Jenis']);
    Route::match(['GET','POST'], '/add' , ['uses' => 'Admin\SubJenisController@add_sub_jenis' , 'as' => 'Add Sub Jenis']);
    Route::match(['GET','POST'], '/edit' , ['uses' => 'Admin\SubJenisController@edit_sub_jenis' , 'as' => 'Edit Sub Jenis']);
    Route::get('/find_sub_jenis/{id}' , ['uses' => 'Admin\SubJenisController@find_sub_jenis' ,'as' => 'Find Sub Jenis']);
    Route::get('/delete-sub-jenis' , ['uses' => 'Admin\SubJenisController@delete_sub_jenis' ,'as' => 'Delete Sub Jenis']);
  });
    // Group Customer
  
  Route::group(['prefix' => 'group-customer'], function(){ 
    Route::match(['GET'] , '/' , ['uses' => 'Admin\GroupCustomerController@index', 'as' => 'List Group Customer' ]);
    Route::match(['GET','POST'], 'add' , ['uses' => 'Admin\GroupCustomerController@add_group_customer' , 'as' => 'Add Group Customer']);
    Route::match(['GET','POST'], 'edit' , ['uses' => 'Admin\GroupCustomerController@edit_group_customer' , 'as' => 'Edit Group Customer']);
    Route::get('find_group_customer/{id}' , ['uses' => 'Admin\GroupCustomerController@find_group_customer' ,'as' => 'Find Group Customer']);
    Route::get('delete' , ['uses' => 'Admin\GroupCustomerController@delete_group_customer' ,'as' => 'Delete Group Customer']);
  });

    // Order Input
  Route::group(['prefix' => 'order_input'], function(){ 
    Route::match(['GET'] , '/' , ['uses' => 'Admin\OrderInputController@index', 'as' => 'List Order Input' ]);
    Route::match(['GET','POST'], '/add-order-input' , ['uses' => 'Admin\OrderInputController@add_order_input' , 'as' => 'Add Order Input']);
    Route::match(['GET','POST'], '/edit-order-input' , ['uses' => 'Admin\OrderInputController@edit_order_input' , 'as' => 'Edit Order Input']);
    Route::get('/find_order_input/{id}' , ['uses' => 'Admin\OrderInputController@find_order_input' ,'as' => 'Find Order Input']);
    Route::get('/delete-order-input' , ['uses' => 'Admin\OrderInputController@delete_order_input' ,'as' => 'Delete Order Input']);
    Route::get('/find-detail-order' , ['uses' => 'Admin\OrderInputController@find_detail_order' ,'as' => 'Find Detail Order']);
  });

  
    // Purchasing
   Route::group(['prefix' => 'purchasing'], function(){ 
    Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\PurchasingController@index', 'as' => 'List Purchasing']);
    Route::match(['GET','POST'], 'add' , ['uses' => 'Admin\PurchasingController@add_purchasing' , 'as' => 'Add Purchasing']);
    Route::match(['GET','POST'], 'edit' , ['uses' => 'Admin\PurchasingController@edit_purchasing' , 'as' => 'Edit Purchasing']);
    Route::match(['GET','POST'], 'detail' , ['uses' => 'Admin\PurchasingController@detail_purchasing' , 'as' => 'Detail Purchasing']);
    Route::match(['GET','POST'], 'edit-tglkirim/{id}' , ['uses' => 'Admin\PurchasingController@edit_tglkirim' , 'as' => 'Edit tglkirim']);
    Route::get('/find-purchasing/{id}' , ['uses' => 'Admin\PurchasingController@find_purchasing' ,'as' => 'Find Purchasing']);
    Route::get('delete-purchasing' , ['uses' => 'Admin\PurchasingController@delete_purchasing' ,'as' => 'Delete Purchasing']);
    Route::get('/autocomplete' , ['uses' => 'Admin\PurchasingController@autocomplete' ,'as' => 'autocomplete']);
    Route::get('/autocompletecategory' , ['uses' => 'Admin\PurchasingController@autocompletecategory' ,'as' => 'autocompletecategory']);
    Route::get('/autocompletesatuan' , ['uses' => 'Admin\PurchasingController@autocompletesatuan' ,'as' => 'autocompletesatuan']);
    Route::get('/send-mail/{email}' , ['uses' => 'Admin\PurchasingController@send_mail' ,'as' => 'send_mail']);
    Route::match(['GET'] , 'jsonpurchasing' , ['uses' => 'Admin\PurchasingController@jsonpurchasing', 'as' => 'jsonpurchasing']);
    Route::match(['GET','POST'], 'bayar' , ['uses' => 'Admin\PurchasingController@bayar_purchasing' , 'as' => 'Bayar Purchasing']);
   
  });
    Route::group(['prefix' => 'return'], function () {
        Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\ReturnController@index' , 'as' => 'Return ERP']);

        Route::match(['GET','POST'], '/search' , ['uses' => 'Admin\ReturnController@search' , 'as' => 'search']);

      });


    // Sumber Sales
  Route::group(['prefix' => 'sumber-sales'], function(){ 
    Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\SumberSalesController@index', 'as' => 'List Sumber Sales' ]);
    Route::match(['GET','POST'], 'add' , ['uses' => 'Admin\SumberSalesController@add_sumber_sales' , 'as' => 'Add Sumber Sales']);
    Route::match(['GET','POST'], 'edit' , ['uses' => 'Admin\SumberSalesController@edit_sumber_sales' , 'as' => 'Edit Sumber Sales']);
    Route::get('/find_sumber_sales/{id}' , ['uses' => 'Admin\SumberSalesController@find_sumber_sales' ,'as' => 'Find Sumber Sales']);
    Route::get('delete' , ['uses' => 'Admin\SumberSalesController@delete_sumber_sales' ,'as' => 'Delete Sumber Sales']);
  });

    // Setting Dashboard
    Route::group(['prefix' => 'setting'], function () {
      Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\SettingController@index', 'as' => 'Setting Dashboard' ]);
      Route::match(['GET','POST'], '/add' , ['uses' => 'Admin\SettingController@add_setting' , 'as' => 'Add Setting dashboard']);
      Route::match(['GET','POST'], '/edit/{id}' , ['uses' => 'Admin\SettingController@edit_setting' , 'as' => 'Edit setting dashboard']);
      Route::match(['GET','POST'], '/preferensi' , ['uses' => 'Admin\SettingController@preferensi' , 'as' => 'Preferensi ERP']);
      Route::match(['GET','POST'], 'preferensi-log' , ['uses' => 'Admin\SettingController@preferensi_log' , 'as' => 'Preferensi LOG']);
    });


    // Setting Jabtan
  Route::group(['prefix' => 'jabatan'], function(){
    Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\JabatanController@index', 'as' => 'Setting Jabatan' ]);
    Route::match(['GET' , 'POST'] , 'AddJabatan' , ['uses' => 'Admin\JabatanController@AddJabatan', 'as' => 'Add Jabatan' ]);
    Route::match(['POST'] , 'EditJabatan' , ['uses' => 'Admin\JabatanController@EditJabatan', 'as' => 'Edit Jabatan' ]);
    Route::match(['GET' , 'POST'] , 'DeleteJabatan' , ['uses' => 'Admin\JabatanController@DeleteJabatan', 'as' => 'Delete Jabatan' ]);
    // Setting Hak akses
    Route::match(['GET' , 'POST'] , '/hak-akses/{id}' , ['uses' => 'Admin\LevelController@index', 'as' => 'Hak Akses' ]);
  });

  // karyawan
  Route::group(['prefix' => 'karyawan'], function () {
    Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\UserController@karyawan' , 'as' => 'Erp Karyawan']);
    Route::get('privilage' , ['uses' => 'Admin\UserController@privilage' , 'as' => 'Erp Privilage']);
    Route::match(['GET' , 'POST'] ,'add' , ['uses' => 'Admin\UserController@created' , 'as' => 'Erp Karyawan Add']);

  });

    // POS
  Route::group(['prefix' => 'pos'], function () {
    Route::match(['GET' , 'POST'], 'getDetailPos' ,['uses' => 'Admin\PosController@getDetailPos' , 'as' => 'getDetailPos']);
    Route::match(['GET' , 'POST'], '/' ,['uses' => 'Admin\PosController@index' , 'as' => 'Pos']);
    Route::match(['GET' , 'POST'], 'addToCart' ,['uses' => 'Admin\PosController@addToCart' , 'as' => 'addToCart']);
    Route::match(['GET','POST'], 'pos-cetak' ,['uses' => 'Admin\PosController@pos_cetak' , 'as' => 'pos_cetak']);
    Route::match(['GET','POST'], '/CreateDetail' ,['uses' => 'Admin\PosController@CreateDetail' , 'as' => 'CreateDetail']);
  });

    // Warehouse
    Route::group(['prefix' => 'warehouse'], function () {
      Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\WarehouseController@index' , 'as' => 'Warehouse ERP']);
      Route::get('autocompletepo' , ['uses' => 'Admin\WarehouseController@autocompletepo' ,'as' => 'autocompletepo']);
      Route::match(['GET','POST'], '/search' , ['uses' => 'Admin\WarehouseController@search' , 'as' => 'search']);

    });

    Route::group(['prefix' => 'kasir'], function () {
      Route::get('/' , ['uses' => 'Admin\KasirController@index', 'as' => 'Kasir index' ]);
      Route::match(['GET' , 'POST'] , 'payment' , ['uses' => 'Admin\KasirController@paymentProgress', 'as' => 'kasir payment' ]);
      Route::post('cart' , ['uses' => 'Admin\KasirController@carting' , 'as' => 'Kasir carting']);
      Route::get('penjualan' , ['uses' => 'Admin\KasirController@penjualan' , 'as' => 'Kasir penjualan']);
      Route::get('detail-penjualan' , ['uses' => 'Admin\KasirController@penjualandetail' , 'as' => 'Kasir penjualan detail']);
    });

    // Bundling
  Route::group(['prefix' => 'bundling'], function(){ 
    Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\BundlingController@index', 'as' => 'List Bundling']);
    Route::match(['GET' , 'POST'] , 'add' , ['uses' => 'Admin\BundlingController@add_bundling' , 'as' => 'Add Bundling']);
    Route::match(['GET' , 'POST'] , 'edit' , ['uses' => 'Admin\BundlingController@edit_bundling' , 'as' => 'Edit Bundling']);
    Route::get('/find_bundling/{id}' , ['uses' => 'Admin\BundlingController@find_bundling' ,'as' => 'Find Bundling']);
    Route::get('delete' , ['uses' => 'Admin\BundlingController@delete_bundling' ,'as' => 'Delete Bundling']);
    Route::match(['GET'] , 'jsonbundling' , ['uses' => 'Admin\BundlingController@jsonbundling', 'as' => 'jsonbundling']);
  });

  Route::group(['prefix' => 'outlet'], function(){ 
    Route::match(['GET' , 'POST'] , '/' , ['uses' => 'Admin\OutletController@index', 'as' => 'List Outlet']);
    Route::match(['GET' , 'POST'] , 'add' , ['uses' => 'Admin\OutletController@add_outlet' , 'as' => 'Add Outlet']);
    Route::match(['GET' , 'POST'] , 'edit' , ['uses' => 'Admin\OutletController@edit_outlet' , 'as' => 'Edit Outlet']);
    Route::get('/find_outlet/{id}' , ['uses' => 'Admin\OutletController@find_outlet' ,'as' => 'Find Outlet']);
    Route::match(['GET' , 'POST'] ,'delete', ['uses' => 'Admin\OutletController@delete_outlet' , 'as' => 'Delete Outlet']);
    Route::match(['GET'] , 'jsonoutlet' , ['uses' => 'Admin\OutletController@jsonoutlet', 'as' => 'jsonoutlet']);
  });


  });




