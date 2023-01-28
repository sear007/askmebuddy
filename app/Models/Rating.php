<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'ratings';
    protected $appends = array(
        'name', 
        'photo', 
    );
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function getNameAttribute()
    {
        return $this->user->name; 
    }
    public function getPhotoAttribute()
    {
        return $this->user->photo; 
    }

}
