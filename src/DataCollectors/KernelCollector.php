<?php
/**
 * Created by PhpStorm.
 * User: zhushiya
 * Date: 12/24/15
 * Time: 10:37 AM
 */

namespace Insight\DataCollectors;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Insight\DataCollectors\CollectorTools;

class KernelCollector
{
    use CollectorTools;
    /**
     * @var  \Insight\Collections
     */
    private $collections;

    public function __construct()
    {
        $this->collections = app('collections');
    }

    /**
     * service providers has been registered.
     */
    public function registered()
    {
        $this->collections->timeline['providers-loaded'] = ['time' => microtime(true)];
    }

    /**
     * @param $request
     * @param $response
     * request has been handled.
     */
    public function handled($request, $response)
    {
        $this->collections->timeline['termination'] = ['time' => microtime(true)];
        $responseData = [
            'version' => $response->getProtocolVersion(),
            'statusCode' => $response->getStatusCode(),
            'headers' => $request->headers->all(),
        ];
        if ($response instanceof JsonResponse) {
            $responseData['type'] = 'json';
            $responseData['content'] = $response->getContent();
        }
        if ($response instanceof Response && isset($response->original)
            && $response->original instanceof View) {
            $responseData['type'] = 'view';
            $responseData['content'] = [
                'view' => $response->original->getName(),
                'path' => $response->original->getPath(),
                'data' => $this->removeObjectAndNil($response->original->getData()),
            ];
        }

        $this->collections->response = $responseData;

        //mongo storage only
        $storage = app('Insight\\Storage\\MongoStorage');
        $storage->store($this->collections);
    }

    /**
     * @param $route \Illuminate\Routing\Route
     * @param $request
     * route matched
     */
    public function route($route, $request)
    {
        $this->collections->response['route'] = [
            'uri' => $route->uri,
            'methods' => $route->methods(),
            'action' => $route->getAction(),
        ];
        $this->collections->timeline['route-matched'] = ['time' => microtime(true)];
    }
}