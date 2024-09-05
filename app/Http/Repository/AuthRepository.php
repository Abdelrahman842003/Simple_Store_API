<?php

    namespace App\Http\Repository;

    use App\Http\Interfaces\AuthInterface;
    use App\Http\Traits\ApiResponseTrait;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;

    class AuthRepository implements AuthInterface
    {
        use ApiResponseTrait;

        public function register($request)
        {
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'min:6'],
            ]);

            if ($validation->fails()) {
                return $this->apiResponse(400, 'Validation Error', $validation->errors());
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return $this->apiResponse(200, 'Created');
        }


        public function login($request)
        {
            $validation = Validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'min:6'],
            ]);
            if ($validation->fails()) {
                return $this->apiResponse(400, 'Validation Error', $validation->errors());
            }

            $userData = $request->only(['email', 'password']);
            if ($token = auth()->attempt($userData)) {
                return $this->respondWithToken($token);
            }

            return $this->apiResponse(400, 'not found', $validation->errors());


        }

        protected function respondWithToken($token)
        {
            $array = [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ];
            return $this->apiResponse(200, 'login', null, $array);
        }
    }
