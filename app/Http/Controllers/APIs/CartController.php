<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $cart = Cart::with('items.product')->where('user_id', $userId)
            ->first();
        //->where('status', 'active')
        return response()->json([
            'data' => $cart
        ], 200);
    }

    public function store(Request $request)
    {
        $userId = $request->user()->id;
        $productId = $request->product_id;
        $quantity = $request->quantity;

        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) {
            $cart = new Cart(['user_id' => $userId]);
            $cart->save();
        }
        $cartItem = $cart->items()->where('product_id', $productId)->first();
        if ($cartItem) {
            // Sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Sản phẩm chưa tồn tại trong giỏ hàng, tạo mới cart_item
            $cartItem = new CartItem(['product_id' => $productId, 'quantity' => $quantity]);
            $cart->items()->save($cartItem);
        }

        // Trả về giỏ hàng đã được cập nhật
        $cart = $cart->load('items.product');
        return response()->json([
            'data' => $cart
        ], 201);
    }


    public function update(Request $request, $productId)
    {
        $userId = $request->user()->id;
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json([
                'message' => 'Cart not found'
            ], 404);
        }

        $cartItem = $cart->items()->where('product_id', $productId)->firstOrFail();
        if (!$cartItem) {
            return response()->json([
                'message' => 'Product not found in cart'
            ], 404);
        }

        // Cập nhật thông tin sản phẩm trong giỏ hàng
        $quantity = $request->input('quantity');
        $price = $cartItem->product->price;
        $cartItem->quantity = $quantity;
        //$cartItem->subtotal = $quantity * $price;
        $cartItem->save();

        // Trả về giỏ hàng đã được cập nhật
        $cart = $cart->load('items.product');
        return response()->json([
            'data' => $cart
        ]);
    }
    public function destroy(Request $request, $productId)
    {
        $userId = $request->user()->id;
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json([
                'message' => 'Cart not found'
            ], 404);
        }

        $cartItem = $cart->items()->where('product_id', $productId)->first();
        if (!$cartItem) {
            return response()->json([
                'message' => 'Product not found in cart'
            ], 404);
        }

        $cartItem->delete();

        // Trả về giỏ hàng đã được cập nhật
        $cart = $cart->load('items.product');
        return response()->json([
            'data' => $cart
        ]);
    }

}
