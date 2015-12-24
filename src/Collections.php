<?php
/**
 * Created by PhpStorm.
 * User: zhushiya
 * Date: 12/22/15
 * Time: 11:46 AM
 */

namespace Insight;

use Illuminate\Http\Request;
use Insight\DataCollectors\CollectorTools;

class Collections
{
    use CollectorTools;

    public $response;
    public $db = [];
    public $timeline = [];

    protected $uid;
    protected $request = [];
    protected $log = [];

    public function __construct(Request $request)
    {
        $this->uid = app('Insight\\Snowflake')->id();
        $this->timeline['script-start'] = ['time' => LARAVEL_START];
        //collect request into collections
        $this->handleRequest($request);
    }

    public function log($logger, $microtime = '')
    {
        $microtime = $microtime === '' ? $microtime(true) : $microtime;
        $logger['microtime'] = $microtime;
        $this->log[] = $logger;
    }

    public function asArray()
    {
        return get_object_vars($this);
    }

    private function handleRequest(Request $request)
    {
        //unset useless headers
        $headers = $request->headers->all();
        $this->request = [
            'headers' => $this->removeElementsFromArray($headers, ['content-type', 'content-length',
                'ceonection', 'cache-control', 'upgrade-insecure-requests', 'dnt']),
            'cookies' => $request->cookie(),
            'server' => $request->server->all(),
            'params' => $request->query->all(),
            'method' => $request->method(),
        ];
    }

    function __get($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }
    }


}