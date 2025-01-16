<?php

namespace App\Http\Middleware;

use App\Http\Controllers\users\checkGuards;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IfLoginUser
{

    private checkGuards $checkGuards;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->checkGuards = new checkGuards();
        if ($this->checkGuards->checkGuardsIfLoginResultNumber() > 0) {
            return $next($request);
        }
        return redirect()->route('login');
    }
}
