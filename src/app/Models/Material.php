<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'minimum_stock',
        'unit_price'
    ];

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function documentItems() {
        return $this->hasMany(DocumentItem::class);
    }
}
