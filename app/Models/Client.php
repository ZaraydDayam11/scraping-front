<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'name', 'paterno', 'materno', 'address', 'postal', 'tdatos', 'email', 'document'];

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
