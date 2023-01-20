<?php

namespace App\Models\Superadmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    // First method uses accessors
    public function getImageAttribute($value)
    {
        if($value){
            return url('/').'/storage/'.$value;
        }
        return '';
    }

    // Second is using a dedicated method
    public function image()
    {
        if($this->image){
            return url('/').'/storage/'.$this->image;
        }
       return '';
    }
}
