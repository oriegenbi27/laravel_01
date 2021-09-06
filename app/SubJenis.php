<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubJenis extends Model
{
    protected $table = 'mst_sub_jenis';
    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function subjenis(){
        return $this->hasMany('App\Produk' , 'id' , 'sub_jenis_id');
      }
}
