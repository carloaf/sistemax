<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_number',
        'issue_date',
        'supplier',
        'comments'
    ];

    public function items()
    {
        return $this->hasMany(DocumentItem::class);
    }
}