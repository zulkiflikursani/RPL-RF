<?php

namespace App\Http\Middleware;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CorsMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Handle CORS headers
        $response = service('response');
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after request
        return $response;
    }
}
