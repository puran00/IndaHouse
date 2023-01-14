<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use voku\helper\ASCII;

class ProductController extends Controller
{
    public function index()
    {
        $products_admin = Product::with('category')->get();
        $products_catalog = Product::query()->with('category')->where('count', '!=',0)->orderByDesc('created_at')->get();
        $products_slider = Product::query()->with('category')->where('count', '!=', 0)->orderByDesc('created_at')->limit(5)->get();

        return response()->json([
            'products_admin'=>$products_admin,
            'products_catalog'=>$products_catalog,
            'products_slider'=>$products_slider,
        ], 200);
    }



    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title'=>['required', 'regex:/[А-Яа-яЁёA-Za-z]/u', 'unique:products'],
            'category_id'=>['required'],
            'img'=>['required', 'max:250', 'mimes:jpg,pnt,bmp,jpeg'],
            'antagonist'=>['required', 'regex:/[А-Яа-яЁёA-Za-z]/u'],
            'price'=>['required', 'numeric', 'between:1,9999999'],
            'age'=>['required', 'date'],
            'count'=>['required', 'numeric', 'between:1,9999999'],
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $product = new Product();
        $path_img = '';

        if ($request->file('img')) {
            $path_img = $request->file('img')->store('/public/img/products');
        }

        $product->title=$request->title;
        $product->category_id=$request->category_id;
        $product->img='/storage/'.$path_img;
        $product->antagonist=$request->antagonist;
        $product->price=$request->price;
        $product->age=$request->age;
        $product->count=$request->count;

        $product->save();

        return response()->json('Товар добавлен', 200);

    }

    public function edit(Product $product)
    {
        return view('admin.product.edit', ['product'=>$product]);
    }


    public function update(Request $request, Product $product)
    {
        $validation = Validator::make($request->all(), [
            'title'=>['required', 'regex:/[А-Яа-яЁёA-Za-z]/u'],
            'category_id'=>['required'],
            'img'=>['max:250', 'mimes:jpg,pnt,bmp,jpeg'],
            'antagonist'=>['required', 'regex:/[А-Яа-яЁёA-Za-z]/u'],
            'price'=>['required', 'numeric', 'between:1,9999999'],
            'age'=>['required', 'date'],
            'count'=>['required', 'numeric', 'between:1,9999999'],
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $product = Product::query()->where('id', $request->id)->first();
        $path_img = '';

        if ($request->file('img')) {
            $path_img = $request->file('img')->store('/public/img/products');
            $product->img='/storage'.$path_img;
        }

        $product = Product::query()->where('id', $request->product_id)->first();
        $product->title=$request->title;
        $product->category_id=$request->category_id;
        $product->antagonist=$request->antagonist;
        $product->price=$request->price;
        $product->age=$request->age;
        $product->count=$request->count;

        $product->update();
        return response()->json('Продукт изменен', 200);
    }


    public function destroy(Product $product, Request $request)
    {
        $product = Product::query()->where('id', $request->id)->delete();
        return response()->json('Продукт удален', 200);
    }
}
