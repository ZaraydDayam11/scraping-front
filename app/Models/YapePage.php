<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YapePage extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'telefono'];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
