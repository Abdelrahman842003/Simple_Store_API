<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\CartInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $CartInterface;

    public function __construct(CartInterface $CartInterface)
    {
        $this->CartInterface = $CartInterface;
    }

    public function addToCart(Request $request){
        return $this->CartInterface->addToCart($request);
    }
    public function deleteFromCart(Request $request){
        return $this->CartInterface->deleteFromCart($request);
    }
    public function UpdateCart(Request $request){
        return $this->CartInterface->UpdateCart($request);
    }
    public function userCart(){
        return $this->CartInterface->userCart();
    }
}
