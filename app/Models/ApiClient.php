<?php
// app/Models/ApiClient.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiClient extends Model
{
    protected $fillable = ['name', 'token_hash', 'ip_whitelist'];
}