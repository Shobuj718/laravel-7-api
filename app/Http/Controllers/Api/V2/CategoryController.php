<?php

namespace App\Http\Controllers\Api\V2;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index(){
        $categories =  Category::where('id', '<', 3)->select('id', 'name', 'created_at')->get();
        return CategoryResource::collection($categories);

    }

    public function show(Category $category){
        return new CategoryResource($category);
    }

    public function store(StoreCategoryRequest $request){

        $data = $request->all();
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = 'categories/' . uniqid() . '.' . $file->extension();
            $file->storePubliclyAs('public', $name);
            $data['photo'] = $name;
        }
        $category = Category::create($data);

        return new CategoryResource($category);

    }

    public function update(Category $category, StoreCategoryRequest $request)
    {
        $category->update($request->all());

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
