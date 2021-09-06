<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupCustomer extends Model
{
    protected $table = 'mst_group_customer';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
