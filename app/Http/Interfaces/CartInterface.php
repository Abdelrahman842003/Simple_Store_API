<?php
    namespace App\Http\Interfaces;

    interface CartInterface
    {
        public function addToCart($request);
        public function deleteFromCart($request);
        public function UpdateCart($request);
        public function userCart();

    }
