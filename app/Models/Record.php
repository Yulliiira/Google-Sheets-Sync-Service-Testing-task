<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
    ];

    public function scopeAllowed($query)
    {
        return $query->where('status', 'Allowed');
    }
}
