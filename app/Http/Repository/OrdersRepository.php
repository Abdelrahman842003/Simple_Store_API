<?php

    namespace App\Http\Repository;

    use App\Http\Interfaces\OrdersInterface;
    use App\Http\Traits\ApiResponseTrait;
    use App\Models\Cart;
    use App\Models\Order;
    use App\Models\OrderItems;
    use App\Rules\CartStockValidation;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;


    class OrdersRepository implements OrdersInterface
    {
        use ApiResponseTrait;

        public function checkout($request)
        {
            $validation = Validator::make($request->header(), [
                'authorization' => new CartStockValidation() //؟؟
            ]);

            if ($validation->fails()) {
                return $this->apiResponse(400, $validation->errors()->first());
            }

            $user = Auth::user()->id;
            $cart = Cart::where('user_id', $user)->with('product')->get();

            $total_price = $cart->sum(function ($items) {
                return $items->product->price * $items->count;
            });


            if ($cart->isNotEmpty()) {
                foreach ($cart as $cartItem) {
                    if ($cartItem->product->stock < $cartItem->count) {
                        return $this->apiResponse(400, 'Product Not Found');
                    }
                    $total = $total_price;
                }

                DB::transaction(function () use ($user, $cart, $total) {
                    $order = Order::create([
                        'user_id' => $user,
                        'total_price' => $total,
                    ]);

                    foreach ($cart as $cartItem) {
                        OrderItems::create([
                            'user_id' => $user,
                            'order_id' => $order->id,
                            'product_id' => $cartItem->product->id,
                            'count' => $cartItem->count,
                            'unit_price' => $cartItem->product->price,
                            'net_price' => $cartItem->product->price * $cartItem->count
                        ]);

                        // تحديث المخزون
                        $cartItem->product->decrement('stock', $cartItem->count);
                        // هنا احذف العنصر من السلة بعد ما تحطه في الطلب
                        $cartItem->delete();
                    }
                });

                return $this->apiResponse(200, 'Order Created and items');
            } else {
                return $this->apiResponse(400, 'Cart Is Empty');
            }

        }
    }

