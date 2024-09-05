<?php

namespace App\Rules;

use App\Models\Cart;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CartStockValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cart = Cart::where('user_id', Auth::user()->id);

        foreach ($cart as $cartItem) {
            if ($cartItem->product->stock < $cartItem->count) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The CartStockValidation error message.';
    }
}
