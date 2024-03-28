<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table = "logs";
    protected $fillable = ['method', 'action', 'url', 'subject', 'description', 'old_properties', 'properties', 'ip_address', 'mac_address'];
}