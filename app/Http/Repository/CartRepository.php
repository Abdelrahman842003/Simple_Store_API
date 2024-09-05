<?php

    namespace App\Http\Repository;

    use App\Http\Interfaces\CartInterface;
    use App\Http\Traits\ApiResponseTrait;
    use App\Models\Cart;
    use App\Rules\SrockValidation;
    use App\Rules\SrockValidationUpdate;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;


    class CartRepository implements CartInterface
    {
        use ApiResponseTrait;

        public $user;

        public function __construct()
        {
            $this->user = Auth::user()->id;
        }

        public function addToCart($request)
        {
            $validation = Validator::make($request->all(), [
                'product_id' => ['required', 'exists:products,id'],
                'count' => ['required', 'integer', new SrockValidation()],
            ]);
            if ($validation->fails()) {
                return $this->apiResponse(400, 'Validation Error', $validation->errors());
            }

            $cart = Cart::where('product_id', $request->product_id)->where('user_id', $this->user)->first();
            if ($cart) {
                $cart->update([
                    'count' => $cart->count + $request->count
                ]);

            } else {
                Cart::create([
                    'product_id' => $request->product_id,
                    'count' => $request->count,
                    'user_id' => $this->user
                ]);
            }


            return $this->apiResponse(200, 'Created');
        }

        public function deleteFromCart($request)
        {
            $cart = Cart::find($request->id);
            if (!$cart) {
                return $this->apiResponse(400, 'Cart Not Found');
            } else {
                $cart->delete();
            }
            return $this->apiResponse(200, 'Deleted');
        }

        public function UpdateCart($request)
        {
            $validation = Validator::make($request->all(), [
                'product_id' => ['required', 'exists:products,id'],
                'count' => ['required', 'integer', new SrockValidationUpdate()],
            ]);
            if ($validation->fails()) {
                return $this->apiResponse(400, 'Validation Error', $validation->errors());
            }
            $cart = Cart::where('product_id', $request->product_id)->where('user_id', $this->user)->first();
            if (!$cart) {
                return $this->apiResponse(400, 'Product Not Found');
            } else {
                $cart->update([
                    'count' => $request->count,
                    'product_id' => $request->product_id
                ]);
            }
            return $this->apiResponse(200, 'Updated');
        }

        public function userCart()
        {
            $carts = Cart::where('user_id', $this->user)->get();
            return $this->apiResponse(200, 'Created', null, $carts);

        }
    }

