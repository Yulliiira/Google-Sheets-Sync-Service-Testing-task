<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SheetConfig extends Model
{
    use HasFactory;
    protected $fillable = ['sheet_url', 'sheet_id'];
}
