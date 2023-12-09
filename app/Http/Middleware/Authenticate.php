<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $bookNow = $request->query('book_now') ?? false;
        $service = $request->query('service');

        if($bookNow) {
            $route = route('auth.index', ['book_now' => $bookNow, 'service' => $service]);
        } else {
            $route = route('auth.index');
        }

        return $request->expectsJson() ? null : $route;
    }
}
