<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function index()
    {
        $orders_user = Order::query()
            ->where('user_id', Auth::id())
            ->where('status', '!=', 'новый')
            ->with('user')
            ->with('carts.product')->get();
        $orders_admin = Order::query()
            ->where('status', '!=', 'новый')
            ->with('user')
            ->with('carts.product')->get();

        return response()->json([
            'orders_admin'=>$orders_admin,
            'orders_user'=>$orders_user
        ], 200);
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request -> all(),[
            'password' => ['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $user = User::query()->where('id', Auth::id())->first();
        if(Auth::user()->password===md5($request->password)){
            $order = Order::query()
                ->where('user_id', Auth::id())
                ->where('status', 'новый')->first();
            $order->status = 'в обработке';

            $order -> update();

            return response()->json('Заказ оформлен', 200);
        }else{
            return response()->json('неверный пароль', 403);
        }
    }

    public function confirmOrder(Request $request){
        $order = Order::query()->where('id', $request->order_id)->first();
        $carts = Cart::query()->where('order_id', $order->id)->get();

        foreach ($carts as $cart){
            $product = Product::query()->where('id', $cart->product_id)->first();

            if($cart->count <= $product->count){
                $product->count -= $cart->count;
                $product->update();
            } else{
                return response()->json('На складе не хватает товара', 400);
            }
        }

        $order->status = 'подтвержден';
        $order->update();
        return response()->json('Ваш заказ обрабатывается',200);

    }

    public function rejectOrder(Request $request){
        $order = Order::query()->where('id', $request->id)->first();
        $order->status = 'отклонен';
        $order->comment = $request->comment;

        $order->update();
        return redirect()->back();
    }

//    public function cancelOrder(Order $order){
//        $order->delete();
//        return response()->json('Заказ отменен');
//    }

    public function cancelOrder(Request $request){
        $order = Order::query()->where('id', $request->id)->first();
        $order->status = 'отменен';
        $order->comment = $request->comment;

        $order->update();
        return redirect()->back();
    }


}
