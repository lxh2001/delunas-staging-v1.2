<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$userTypes): Response
    {
        $user = $request->user();

        // Check if the user is authenticated and has the required user type
        if ($user && in_array($user->user_type, $userTypes)) {
            return $next($request);
        }

        // Redirect or handle unauthorized access as needed
        // Access denied, return 403 Forbidden response
        abort(403, 'Access Denied');
        // return redirect()->route('index'); // Change the route as per your application's needs
    }
}
