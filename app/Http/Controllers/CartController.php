<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $order = Order::query()
            ->where('user_id', Auth::id())
            ->where('status', 'новый')
            ->first();
        $carts = Cart::query()
            ->where('order_id', $order->id)
            ->with('product')
            ->get();


        return response()->json([
           'carts'=>$carts,
            'order'=>$order,
        ]);
    }


    public function store(Request $request)
    {
        $product = Product::query()->where('id', $request->id)->first();

        $order = Order::query()
            ->where('user_id', Auth::id())
            ->where('status', 'новый')
            ->firstOrCreate(['user_id'=>Auth::id()], ['status'=>'новый']);

        $cart = Cart::query()
            ->where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->firstOrCreate(['order_id'=>$order->id], ['product_id'=>$product->id]);

        if ($cart->count) {
            if ($product->count > $cart->count) {
                $cart->count += 1;
                $cart->summ += $product->price;
                $order->summ+=$product->price;

                $order->save();
                $cart->save();
                return response()->json('Товар добален в карзину', 200);
            }
            else {
                return response()->json('Товара нет на складе', 400);
            }
        }
        else {
            $cart->count = 1;
            $cart->summ=$product->price;
            $order->summ+=$cart->summ;

            $order->save();
            $cart->save();
            return response()->json('Товар добален в корзину', 200);
        }
    }


    public function update(Request $request, Cart $cart)
    {
        $product = Product::query()->where('id', $request->id)->first();

        $order = Order::query()
            ->where('user_id', Auth::id())
            ->where('status', 'новый')
            ->first();
        $cart = Cart::query()
            ->where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cart->count > 1) {
            $cart->count-=1;
            $cart->summ-=$product->price;
            $order->summ-=$product->price;

            $order->update();
            $cart->update();
            $message='Товар удален';
        } else {
            $order->summ-=$cart->summ;

            $cart->delete();
            $order->update();
            $message='Товар удален';
        }
        return response()->json($message, 200);
    }


    public function deleteFromCart(Cart $cart, Request $request)
    {
        $order = Order::query()
            ->where('user_id', Auth::id())
            ->where('status', 'новый')
            ->first();

        $cart = Cart::query()
            ->where('order_id', $order->id)
            ->where('product_id', $request->product_id)
            ->first();

        $order->summ -= $cart->summ;
        $order->update();
        $cart->delete();
        return response()->json('Товар удалён', 200);
    }

    public function destroy(Cart $cart, Request $request){
        $order = Order::query()
            ->where('user_id', Auth::id())
            ->where('status', 'новый')
            ->first();
        $cart = Cart::query()->where('id', $request->id)->first();

        $order->update();
        $cart->delete();

        return response()->json('Товар удален', 200);
    }
}
