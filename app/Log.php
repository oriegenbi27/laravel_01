<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log_aktifitas extends Model
{
    protected $table = 'mst_log_aktifitas';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];


    public function detailorder(){
        return $this->hasMany(DetailOrder::class,'id_order', 'id');
      }
}
