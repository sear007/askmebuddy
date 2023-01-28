<?php

namespace App\Models;

use App\Models\Superadmin\Category;
use App\Models\Superadmin\Payment;
use App\Models\Superadmin\Service;
use App\Models\Superadmin\Contact;
use App\Models\Superadmin\VendorImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dateFormat = 'U';
    protected $appends = array(
        'total_rating', 
        'avg_rating',
        'fake_images',
    );
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
    public function rating(){
        return $this->hasMany(Rating::class, 'vendor_id');
    }
    public function images(){
        return $this->hasMany(VendorImage::class, 'vendor_id');
    }
    public function getTotalRatingAttribute()
    {
        return $this->rating->count('rating'); 
    }
    public function getAvgRatingAttribute()
    {
        return $this->rating->avg('rating'); 
    }
    public function getFakeImagesAttribute()
    {
        return array(
            'https://loremflickr.com/640/480/'.$this->category->name.'?random='.$this->id.'1',
            'https://loremflickr.com/640/480/'.$this->category->name.'?random='.$this->id.'2',
            'https://loremflickr.com/640/480/'.$this->category->name.'?random='.$this->id.'3',
        ); 
    }
}
