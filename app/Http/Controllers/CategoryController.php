<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Canton;
use App\Models\District;
use App\Models\Company;

class CategoryController extends Controller
{
    public function categories(){

        $categories = Category::select('id', 'name')->get();
        return response()->json($categories,200, [], JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        $subcategories = SubCategory::select('sub_categories.id', 'sub_categories.name')
        ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
        ->where('categories.id', $id)
        ->get();
         return response()->json($subcategories,200, [], JSON_UNESCAPED_UNICODE);
    }

    public function canton(){
        $canton = Canton::select('id', 'name')->get();
        return response()->json($canton ,200, [], JSON_UNESCAPED_UNICODE);
    }


    public function district($id)
    {
        $district = District::select('districts.id', 'districts.name')
        ->join('cantons', 'districts.canton_id', '=', 'cantons.id')
        ->where('cantons.id', $id)
        ->get();
         return response()->json($district,200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getItems($id1, $id2, $id3, $id4)
    {
       
        $items = Company::when($id1 != 0, function($query) use ($id1) {
            return $query->where('companies.category_id', $id1);
        })->when($id2 != 0, function($query) use ($id2) {
            return $query->where('companies.sub_categories_id', $id2);
        })->when($id3 != 0, function($query) use ($id3) {
            return $query->where('companies.canton_id', $id3);
        })->when($id4 != 0, function($query) use ($id4) {
            return $query->where('companies.district_id', $id4);
        })->get();
        
         return response()->json($items,200, [], JSON_UNESCAPED_UNICODE);
    }
}
