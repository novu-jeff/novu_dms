<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileHistory extends Model
{
    use HasFactory;

    protected $table = 'file_history';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
