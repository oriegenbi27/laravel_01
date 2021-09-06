<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPrefensi extends Model
{
    protected $table = 'mst_log_prefensi';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function payment(){
      return $this->belongsTo('App\Payment');
    }

    // public function Prefensi(){
    //   return $this->belongsTo('App\Prefensi');
    // }
}
