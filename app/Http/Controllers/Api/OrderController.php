<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Interfaces\OrdersInterface;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class OrderController extends Controller
    {
        public $OrdersInterface;

        public function __construct(OrdersInterface $OrdersInterface)
        {
            $this->OrdersInterface = $OrdersInterface;
        }

        public function checkout(Request $request)
        {
            return $this->OrdersInterface->checkout($request);
        }
    }
