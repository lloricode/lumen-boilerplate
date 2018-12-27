<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/25/18
 * Time: 2:21 PM
 */

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class CheckAcceptHeaderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('accept') != 'application/json') {
            return response([
                'error' => [
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Your request header must contain [Accept = application/json].',
                ],
            ], Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}