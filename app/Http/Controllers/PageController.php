<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome() {
        $products = Product::query()->orderBy('created_at')->limit(5)->get();
        return view('welcome', ['products'=>$products]);
    }

    public function RegistrationPage() {
        return view('user.registration');
    }

    public function Auth() {
        return view('user.auth');
    }

    public function CatalogPage() {
        return view('catalog');
    }

    public function InfoPage(Product $product){
        return view('info', ['product'=>$product]);
    }

    public function ContactsPage(){
        return view('contact');
    }

    public function UserPage() {
        return view('user.index');
    }

    public function CartPage() {
        return view('cart');
    }

    public function AdminPage() {
        return view('admin.index');
    }

    public function CategoryPage() {
        return view('admin.category.index');
    }

    public function CategoryAddPage() {
        return view('admin.category.add');
    }

    public function EditCategoryPage(Category $category) {
        return view('admin.category.edit', ['category'=>$category]);
    }

    public function ProductPage() {
        return view('admin.product.index');
    }

    public function ProductAddPage() {
        return view('admin.product.add');
    }

    public function AdminOrdersPage(){
        return view('admin.orders.index');
    }

    public function UserOrderPage(){
        return view('user.orders');
    }


}
