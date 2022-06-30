<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(){
        $categories =  Category::select('id', 'name', 'created_at')->get();
        return CategoryResource::collection($categories);

    }

    public function show(Category $category){
        return new CategoryResource($category);
    }
}