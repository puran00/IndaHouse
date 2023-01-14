<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'categories'=>$categories,
        ], 200);

    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title'=>['required', 'regex:/[А-Яа-яЁёA-Za-z]/u'],
        ], [
            'title.required'=>'Обязательное поле',
            'title.regex'=>'Поле может содержать только кириллицу/латиницу',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $category = new Category();
        $category->title=$request->title;

        $category->save();

        return response()->json('Категория добавлена', 200);
    }


    public function update(Request $request, Category $category)
    {
        $validation = Validator::make($request->all(), [
           'title'=>['required'],
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $category = Category::query()->where('id', $request->category_id)->first();
        $category->title=$request->title;
        $category->update();
        return response()->json('Категория изменена', 200);

    }

    public function destroy(Category $category, Request $request)
    {
        $category = Category::query()->where('id', $request->id_category)->delete();

        return response()->json('Категория удалена', 200);
    }
}
