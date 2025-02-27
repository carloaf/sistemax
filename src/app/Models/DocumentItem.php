<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'material_id',
        'quantity',
        'unit_price'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
