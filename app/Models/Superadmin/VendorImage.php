<?php

namespace App\Models\Superadmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorImage extends Model
{
    use HasFactory;
    protected $table = 'vendor_images';
    protected $guarded = [];
}
