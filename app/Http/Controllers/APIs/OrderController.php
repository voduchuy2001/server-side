<?php
namespace App\Http\Controllers\APIs;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class OrderController extends Controller
{
    public function store(Request $request)
    {
        $userId = $request->user()->id;
        $cart = Cart::with('items.product')->where('user_id', $userId)->first();
        if (!$cart) {
            return response()->json([
                'message' => 'Cart is empty'
            ], 400);
        }
        $order = new Order([
            'user_id' => $userId,
            'total_price' => $cart->getTotalPrice()
        ]);
        $order->save();
        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }
        $cart->status = 'ordered';
        $cart->save();
        return response()->json([
            'data' => $order
        ], 201);
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $orders = Order::with('items.product')->where('user_id', $userId)->get();
        return response()->json([
            'data' => $orders
        ], 200);
    }

    public function show(Request $request, $id){
        $userId = $request->user()->id;
        $order = Order::with('items.product')->where('user_id', $userId)->find($id);
        if (!$order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }
        return response()->json([
            'data' => $order
        ], 200);
    }
}
