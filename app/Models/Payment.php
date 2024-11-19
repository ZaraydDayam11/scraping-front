<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'fecha', 'codigo', 'operacion', 'voucher_id'];

    public function imageyape()
    {
        return $this->morphOne(PaymentYapeImage::class, 'imageable');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
}
