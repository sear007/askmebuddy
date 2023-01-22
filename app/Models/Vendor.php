<?php

namespace App\Models;

use App\Models\Superadmin\Category;
use App\Models\Superadmin\Payment;
use App\Models\Superadmin\Service;
use App\Models\Superadmin\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function contact(){
        return $this->hasOne(Contact::class, 'vendor_id');
    }
    public function payment(){
        return $this->hasOne(Payment::class, 'vendor_id');
    }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function service(){
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
