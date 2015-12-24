<?php
/**
 * Created by PhpStorm.
 * User: zhushiya
 * Date: 12/24/15
 * Time: 10:52 AM
 */

namespace Insight\DataCollectors;


class LogCollector
{
    public function handle($level,$message,$context)
    {
        app('collections')->log(compact('level', 'message', 'context'), microtime(true));
    }
}