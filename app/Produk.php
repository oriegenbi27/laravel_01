<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'mst_produk';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function brand(){
        return $this->hasMany(Brand::class, 'id','brand_id');
      }
    public function jenisbarang(){
        return $this->hasMany(JenisBarang::class, 'id' ,'jenis_barang_id');
      }
    public function subjenis(){
        return $this->hasMany(SubJenis::class, 'id','sub_jenis_id');
      }
      public function detailproduk(){
        return $this->hasMany(DetailProduk::class,'id_produk', 'id');
      }
      public function gratis(){
        return $this->hasMany('App\Produk' , 'id' , 'fitem');
      }
      public function item(){
        return $this->hasMany('App\Produk' , 'id' , 'item');
      }


}
