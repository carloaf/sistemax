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
        'type',
        'supplier',
        'recipient',
        'comments'
    ];

    public function items()
    {
        return $this->hasMany(DocumentItem::class);
    }

    public function documentItems()
    {
        return $this->hasMany(DocumentItem::class);
    }
}