<?php
/**
 * Created by PhpStorm.
 * User: zhushiya
 * Date: 12/24/15
 * Time: 11:39 AM
 */

namespace Insight;

use Closure;

class Middleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request)->header(
            'Insight-ID', app('collections')->uid
        );
        return $response;
    }
}