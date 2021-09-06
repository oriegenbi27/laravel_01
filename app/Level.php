<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'mst_level';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function menu(){
      return $this->belongsTo(Menu::class);
    }

    public function jabatan(){
      return $this->hasMany('App\Jabatan' , 'id' , 'jabatan_id');
    }

    
    public function level(){
      return $this->hasMany('App\Jabatan' , 'id' , 'menu_id' );
    }
}
