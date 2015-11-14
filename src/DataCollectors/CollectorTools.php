<?php
/**
 * Created by PhpStorm.
 * User: zhushiya
 * Date: 11/15/15
 * Time: 1:50 AM
 */

namespace Insight\DataCollectors;


trait CollectorTools
{
    public function hidePassword(array $data)
    {
        foreach ($data as $k => &$v) {
            if ((strpos($k, 'pass') !== false)) {
                $v = '**';
            }
        }
        return $data;
    }
}