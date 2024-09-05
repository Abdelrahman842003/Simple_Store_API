<?php

    namespace App\Rules;

    use App\Models\Cart;
    use App\Models\Product;
    use Illuminate\Contracts\Validation\Rule;
    use Illuminate\Support\Facades\Auth;

    class SrockValidationUpdate implements Rule
    {
        /**
         * Create a new rule instance.
         *
         * @return void
         */
        public function __construct()
        {
            //
        }

        /**
         * Determine if the validation rule passes.
         *
         * @param string $attribute
         * @param mixed $value
         * @return bool
         */
        public function passes($attribute, $value)
        {
            $product_id = request('product_id');
            $user_id = Auth::user()->id;

            // البحث عن المنتج المتاح
            $product = Product::where('id', $product_id)
                ->where('stock', '>=', $value)
                ->first();

            if (!$product) {
                return false; // المنتج غير متاح أو المخزون غير كافٍ
            }
                // البحث عن العنصر في العربة للمستخدم الحالي
                $cart = Cart::where('user_id', $user_id)
                    ->where('product_id', $product_id)
                    ->first();
            // التحقق من الكمية المطلوبة مقارنة بالمخزون
            if ($cart && ($value) > $product->stock) {
                return false; // الكمية المطلوبة أكبر من المخزون المتاح
            }

            return true; // التحقق ناجح، الكمية المطلوبة متاحة
        }




        /**
         * Get the validation error message.
         *
         * @return string
         */
        public
        function message()
        {
            return 'The Stock error .';
        }
    }
