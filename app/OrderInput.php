<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderInput extends Model
{
    use SoftDeletes;

    protected $table = 'trf_booking';
    protected $fillable = ['grand_total'];

    public const ORDERCODE = 'INV';
    public const PAID = 'paid';
    public const UNPAID = 'unpaid';
 
    public const CREATED = 'created';
    public const CONFIRMED = 'confirmed';
    public const DELIVERED = 'delivered';
    public const COMPLETED = 'completed';
    public const CANCELLED = 'cancelled';

    public function detailorder(){
        return $this->hasMany(DetailOrder::class,'id_order', 'id');
      }

      public static function generateCode($owner,$code)
      {

        $dateCode = $code . '/' . date('ymd') . '/' .\General::integerToRoman(date('m')). '/' .\General::integerToRoman(date('d')). '/';

        $lastOrder = self::select([\DB::raw('MAX(trf_booking.code) AS last_code')])
          ->where('id_owner',$owner )
          ->where('code', 'like', $dateCode . '%')
          ->first();

        $lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
        
        $orderCode = $dateCode . '00001';
        if ($lastOrderCode) {
          $lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
          $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
          
          $orderCode = $dateCode . $nextOrderNumber;
        }

        if (self::_isOrderCodeExists($orderCode)) {
          return generateOrderCode();
        }
        
        return $orderCode;
      }

      public function isPaid(){
        return $this->payment == self::PAID;
      }

      private static function _isOrderCodeExists($orderCode){
        return self::where('code', '=', $orderCode)->exists();
      }

      protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
