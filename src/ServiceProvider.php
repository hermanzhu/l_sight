<?php
/**
 * Created by PhpStorm.
 * User: zhushiya
 * Date: 11/14/15
 * Time: 9:33 PM
 */

namespace Insight;

use Illuminate\Foundation\Application;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    protected $defer = false;

    public function __construct(Application $application)
    {
        $this->app = $application;
        $this->app->singleton('collections', 'Insight\\Collections');
        $this->collections = app('collections');
    }

    public function register()
    {
        $this->dispatcherListener();
        $this->app['Illuminate\Contracts\Http\Kernel']->pushMiddleware('Insight\\Middleware');
    }

    /**
     * dispatcher listener
     */
    public function dispatcherListener()
    {
        $events = app('events');
        $events->listen('Insight\ServiceProvider', 'Insight\\DataCollectors\\KernelCollector@registered');
        $events->listen('router.matched', 'Insight\\DataCollectors\\KernelCollector@route');
        $events->listen('kernel.handled', 'Insight\\DataCollectors\\KernelCollector@handled');
        $events->listen('illuminate.log', 'Insight\\DataCollectors\\LogCollector@handle');
        $events->listen('illuminate.query', 'Insight\\DataCollectors\\EloquentCollector@query');
    }

    public function boot()
    {
    }
}