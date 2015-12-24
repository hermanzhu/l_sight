<?php
/**
 * Created by PhpStorm.
 * User: zhushiya
 * Date: 11/15/15
 * Time: 1:47 AM
 */

namespace Insight\DataCollectors;

class EloquentCollector
{
    public function query($query, $bindings, $time, $connectionName)
    {
        app('collections')->db[] = compact('query', 'bindings', 'time', 'connectionName');
    }
}