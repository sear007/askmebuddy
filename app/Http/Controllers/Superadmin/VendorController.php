<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function Vendor($id){
        return Vendor::with(['category', 'service', 'payment', 'contact', 'images'])->find($id);
    }
    public function Vendors(Request $request){
        $offset = (request('page') - 1) * request('perPage');
        return Vendor::with(['category', 'service', 'payment', 'contact', 'images'])
        ->where('business_name', 'like', '%'.request('search').'%')
        ->where('service_id', '=', request('serviceId'))
        ->where('category_id', '=', request('catId'))
        ->limit(request('perPage'))->offset($offset)
        ->get();
    }
    public function Store(Request $request){
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'category_id' => 'required|exists:categories,id',
        ]);
        if ($validator->fails()) 
        {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $vendor = Vendor::create([
            'service_id' => request('service_id'),
            'category_id' => request('category_id'),
            'business_name' => request('business_name'),
            'legal_business_name' => request('legal_business_name'),
            'building' => request('building'),
            'street' => request('street'),
            'landmark' => request('landmark'),
            'area' => request('area'),
            'city' => request('city'),
            'state' => request('state'),
            'country' => request('country'),
        ]);

        $vendor->contact()->create([
            'contact_person' => request('contact_person'),
            'mobile_no' => request('mobile_no'),
            'toll_free_no' => request('toll_free_no'),
            'telegram_number' => request('telegram_number'),
            'email' => request('email'),
            'website' => request('website'),
            'facebook' => request('facebook'),
            'twitter' => request('twitter'),
            'instagram' => request('instagram'),
            'youtube' => request('youtube'),
            'other' => request('other'),
        ]);

        $vendor->payment()->create([
            'cash' => request('cash'),
            'debit_card' => request('debit_card'),
            'credit_card' => request('credit_card'),
            'american_express_card' => request('american_express_card'),
            'etc' => request('etc'),
        ]);

        if($request->hasFile('images')){
            $images = request('images');
            foreach ($images as $image) {
                $url = uploadImageVendor($image);
                $vendor->images()->create(['url' => $url]);
            }
        }
        return $this->sendResponse($vendor, 'Done!');
    }
    public function Update(Request $request){
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:vendors,id',
            'service_id' => 'required|exists:services,id',
            'category_id' => 'required|exists:categories,id',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $vendor = Vendor::find(request('vendor_id'));
        $vendor->update([
            'service_id' => request('service_id'),
            'category_id' => request('category_id'),
            'business_name' => request('business_name'),
            'legal_business_name' => request('legal_business_name'),
            'building' => request('building'),
            'street' => request('street'),
            'landmark' => request('landmark'),
            'area' => request('area'),
            'city' => request('city'),
            'state' => request('state'),
            'country' => request('country'),
        ]);
        $vendor->contact()->update([
            'contact_person' => request('contact_person'),
            'mobile_no' => request('mobile_no'),
            'toll_free_no' => request('toll_free_no'),
            'telegram_number' => request('telegram_number'),
            'email' => request('email'),
            'website' => request('website'),
            'facebook' => request('facebook'),
            'twitter' => request('twitter'),
            'instagram' => request('instagram'),
            'youtube' => request('youtube'),
            'other' => request('other'),
        ]);
        $vendor->payment()->update([
            'cash' => request('cash'),
            'debit_card' => request('debit_card'),
            'credit_card' => request('credit_card'),
            'american_express_card' => request('american_express_card'),
            'etc' => request('etc'),
        ]);
        if($request->hasFile('images')){
            $images = request('images');
            foreach ($images as $image) {
                $url = uploadImageVendor($image);
                $vendor->images()->create(['url' => $url]);
            }
        }
        return $this->sendResponse($vendor->id, 'Done!');
    }
    public function Destroy($id){
        $vendor = Vendor::find($id);
        $vendor->delete();
        return $this->sendResponse([], 'Done!');
    }
}
