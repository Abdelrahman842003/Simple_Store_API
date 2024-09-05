<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Interfaces\AuthInterface;
    use Illuminate\Http\Request;


    class AuthController extends Controller

    {
        public $AuthInterface;

        public function __construct(AuthInterface $AuthInterface)
        {
            $this->AuthInterface = $AuthInterface;
        }

        public function register(Request $request)
        {
            return $this->AuthInterface->register($request);
        }
        public function login(Request $request)
        {
            return $this->AuthInterface->login($request);
        }
    }
