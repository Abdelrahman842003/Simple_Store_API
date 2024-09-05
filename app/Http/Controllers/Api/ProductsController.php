<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Interfaces\ProductsInterface;

    class ProductsController extends Controller
    {
        public $ProductsInterface;

        public function __construct(ProductsInterface $ProductsInterface)
        {
            $this->ProductsInterface = $ProductsInterface;
        }

        public function products()
        {
            return $this->ProductsInterface->products();
        }
    }
