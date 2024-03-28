<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use LogTrait, HasFactory, Notifiable;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }
    public function unit()
    {
        return $this->belongsToMany(Units::class, 'documents_units');
    }
    public function units()
    {
        return $this->belongsTo(Units::class, 'location_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    // public function countshared()
    // {
    //     return $this->belongsToMany(Units::class, 'documents_units')->wherePivot('units_id', 1);
    // }
}