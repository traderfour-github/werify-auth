<?php

namespace App\Http\Middleware\Log;

use App\Jobs\Log\StoreLogJob;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRequest
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
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, \Closure $next): Response
    {
        return $next($request);
    }

    /**
     * Handle the response for the request.
     *
     *
     * @return void
     */
    public function terminate(Request $request, Response $response)
    {
        $logData = [
            'ip' => $request->getClientIp(),
            'url' => $request->url(),
            'response' => $response->content(),
            'device' => $request->userAgent(),
            'session' => $this->getSession(),
            'agent' => $request->userAgent(),
        ];

        dispatch(new StoreLogJob($logData));
    }

    /**
     * Get the session implementation from the request.
     *
     * @return mixed
     */
    private function getSession()
    {
        if ($this->request->hasSession()) {
            return json_encode($this->request->session());
        }

        return '';
    }
}
