<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    public function Store(Request $request){
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:vendors,id',
            'comments' => 'required',
            'rating' => 'required|numeric|min:0|max:5',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $rating = Rating::create($request->all());
        return $this->sendResponse($rating, 'Done!');
    }
    public function getRating($vendorId){
        return Rating::where('vendor_id', $vendorId)
        ->orderBy('id', 'desc')
        ->get();
    }
    
}
