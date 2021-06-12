<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableCatPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'post', 'category', 
    ];
}
