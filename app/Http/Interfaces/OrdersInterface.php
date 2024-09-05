<?php
    namespace App\Http\Interfaces;

    interface OrdersInterface
    {
        public function checkout($request);
    }
