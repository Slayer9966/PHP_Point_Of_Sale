<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Bills()
    {
        return $this->hasOne(Bill::class);
    }
    public function Sold(){
        return $this->hasMany(Sold::class);
    }
    public function Stocks(){
        return $this->hasMany(Stocks::class);
    }
}
