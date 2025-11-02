<?php



namespace App\Http\Middleware;

use Closure;

class RestrictUrlAccess
{
    public function handle($request, Closure $next)
    {
     
   
            if ($this->isDirectUrlAccess($request)) {
                return response()->view('error.error-404', [], 404);
            }
    
            return $next($request);
        }
    
        private function isDirectUrlAccess($request)
        {
            return $request->headers->get('referer') === null;
        }
}
