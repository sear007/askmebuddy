<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Superadmin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function Store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'icon_name' => 'required',
            'image' => 'required|image|mimes:png|dimensions:max_width=512,max_height=512',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $data = $request->all();
        $data['image'] = uploadIcon($request->file('image'));
        $category = Category::updateOrCreate(['name' => $data['name']],
            ['icon_name' => $data['icon_name'],'image' => $data['image'],]
        );
        return $this->sendResponse($category, 'Done!');
    }

    public function Categories(){
        return Category::get();
    }
}
