<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'unit',
        'quantity',
        'minimum_stock',
        'unit_price',
        'average_price'
    ];

    protected $appends = ['total_value'];

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function documentItems() {
        return $this->hasMany(DocumentItem::class);
    }

    // Accessors
    public function getTotalValueAttribute()
    {
        return $this->quantity * $this->average_unit_price;
    }

    // Scopes
    public function scopeWithStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function getOldestUnitPrice()
    {
        return $this->documentItems()
            ->oldest('created_at')
            ->value('unit_price');
    }
}
