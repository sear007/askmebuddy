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
        $query->when(request('cat_id'), function($q){
            $q->whereCategoryId(request('cat_id'));
        });
        $query->when(request('search'), function($q){
            $q->where('business_name', 'like', '%' . request('search') . '%');
        });
        if($request->has('page') && $request->has('per_page')){
            $offset = (request('page') - 1) * request('per_page');
            $vendors = $query->limit(request('per_page'))->offset($offset);
        }
        $vendors = $query->get();
        for ($i=0; $i < $total; $i++) { 
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
