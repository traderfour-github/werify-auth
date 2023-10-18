<?php

namespace App\Http\Middleware;

use App\Jobs\Application\CheckApplicationKeyJob;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class ApplicationKey
{
    protected $request;

    /**
     * Create a new LogRequest instance.
     *
     *
     * @return void
     */
    public function __construct(Request $request)
    {
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $app = dispatch_sync(new CheckApplicationKeyJob($request));
        if (! $app) {
            throw new UnauthorizedException('invalid api-key!');
        }
        $request->merge(['application' => $app]);

        return $next($request);
    }
}
