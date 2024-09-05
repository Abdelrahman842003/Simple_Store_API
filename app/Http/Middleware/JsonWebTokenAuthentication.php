<?php

    namespace App\Http\Middleware;

    use App\Http\Traits\ApiResponseTrait;
    use Closure;
    use Exception;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Tymon\JWTAuth\Facades\JWTAuth;
    use Tymon\JWTAuth\Exceptions\TokenInvalidException;
    use Tymon\JWTAuth\Exceptions\TokenExpiredException;

    class JsonWebTokenAuthentication
    {
        /**
         * Handle an incoming request.
         *
         * @param Request $request
         * @param Closure(Request): (Response|RedirectResponse) $next
         * @return Response|RedirectResponse
         */
        use ApiResponseTrait;

        public function handle(Request $request, Closure $next)
        {
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (TokenInvalidException $e) {
                return $this->apiResponse(422, "Token is invalid");
            } catch (TokenExpiredException $e) {
                return $this->apiResponse(401, "Token has expired");
            } catch (Exception $e) {
                return $this->apiResponse(422, "Authorization token not found");
            }

            return $next($request);

        }
    }
