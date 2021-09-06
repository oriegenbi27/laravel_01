<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    protected $table = 'mst_jenis_barang';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function jenisbarang(){
        return $this->hasMany('App\Produk' , 'id' , 'jenis_barang_id');
      }

}
