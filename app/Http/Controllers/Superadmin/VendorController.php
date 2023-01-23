<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    //
    public function Vendors(Request $request){
        $vendors = [];
        $total = 0;
        $query = Vendor::with(['category', 'service', 'payment', 'contact']);
        $query->when(request('catId'), function($q){
            $q->whereCategoryId(request('catId'));
        });
        $query->when(request('search'), function($q){
            $q->where('business_name', 'like', '%' . request('search') . '%');
        });
        if($request->has('page') && $request->has('perPage')){
            $offset = (request('page') - 1) * request('perPage');
            $vendors = $query->limit(request('perPage'))->offset($offset);
        }
        $vendors = $query->get();
        // for ($i=0; $i < count($vendors); $i++) { 
        //     $vendors[$i]['images'] = array(
        //         'https://loremflickr.com/1280/960/'.$vendors[$i]['category']['name'].'?lock='.$vendors[$i]['id'].'1',
        //         'https://loremflickr.com/1280/960/'.$vendors[$i]['category']['name'].'?lock='.$vendors[$i]['id'].'2',
        //         'https://loremflickr.com/1280/960/'.$vendors[$i]['category']['name'].'?lock='.$vendors[$i]['id'].'3',
        //         'https://loremflickr.com/1280/960/'.$vendors[$i]['category']['name'].'?lock='.$vendors[$i]['id'].'4',
        //         'https://loremflickr.com/1280/960/'.$vendors[$i]['category']['name'].'?lock='.$vendors[$i]['id'].'5',
        //     );
        // };
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
