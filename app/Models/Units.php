<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function documents()
    {
        return $this->belongsToMany(Documents::class, 'documents_units');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function document()
    {
        return $this->hasMany(Documents::class);
    }
}