<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'mst_jabatan';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function Menu(){
      return $this->belongsTo(Menu::class);
    }

    
    public function Level(){
      return $this->hasMany(Level::class);
    }

    // public function getmenus(){
    //   return $this->hasMany('App\Menu' , 'id' , 'id_menu');
    // }

}
