<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use LogTrait, HasFactory, Notifiable;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}