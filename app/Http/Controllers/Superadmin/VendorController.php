<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    //
    public function Vendors(Request $request){
        $vendors = Vendor::with(['category', 'service', 'payment', 'contact'])->get();
        for ($i=0; $i < count($vendors); $i++) { 
            $vendors[$i]['images'] = array(
                ['id' => '', 'url' => 'https://loremflickr.com/1280/960/'.$vendors[$i]['category']['name'].'?lock='.$vendors[$i]['id'].'1'],
                ['id' => '', 'url' => 'https://loremflickr.com/1280/960/'.$vendors[$i]['category']['name'].'?lock='.$vendors[$i]['id'].'2'],
                ['id' => '', 'url' => 'https://loremflickr.com/1280/960/'.$vendors[$i]['category']['name'].'?lock='.$vendors[$i]['id'].'3'],
                ['id' => '', 'url' => 'https://loremflickr.com/1280/960/'.$vendors[$i]['category']['name'].'?lock='.$vendors[$i]['id'].'4'],
                ['id' => '', 'url' => 'https://loremflickr.com/1280/960/'.$vendors[$i]['category']['name'].'?lock='.$vendors[$i]['id'].'5'],
            );
        };
        return $vendors;
    }

    public function Store(Request $request){
        $vendor = Vendor::create([
            'user_id' => 504,
            'service_id' => 1,
            'category_id' => 1,
            'business_name' => 'Hello world',
        ]);
        $vendor->contact()->updateOrCreate([
            'vendor_id' => $vendor->id,
        ], [
            'contact_person' => 'sear 2'
        ]);
    }
}
