<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'type',
        'quantity',
        'observation'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id'); // Nome correto da relação
    }
}
