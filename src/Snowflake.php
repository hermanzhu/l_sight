<?php
/**
 * Created by PhpStorm.
 * User: zhushiya
 * Date: 12/23/15
 * Time: 11:41 AM
 */

namespace Insight;


class Snowflake
{
    const EPOCH = 1420041600000;
    const DEFAULT_MACHINE_ID = 511;

    private $machineID;

    public function __construct($machineID = '')
    {
        //init machine id
        if (!empty($machineID) && is_numeric($machineID) && $machineID >= 0 && $machineID < 512) {
            $this->machineID = $machineID;
        }
        if (function_exists('env')) {
            $this->machineID = env('MACHINE_ID', self::DEFAULT_MACHINE_ID);
        }
        $this->machineID = self::DEFAULT_MACHINE_ID;
    }

    public function id()
    {
        //check system time
        $time = floor(microtime(true) * 1000);
        if ($time <= self::EPOCH) {
            throw new InvalidSystemClockException(sprintf("Clock moved backwards. Refusing to generate" .
                "id for %d milliseconds", (self::EPOCH - $time)));
        }

        $time -= self::EPOCH;
        $base = decbin(pow(2, 40) - 1 + $time);
        $machineID = decbin(pow(2,9) - 1 + $this->machineID);
        $random = mt_rand(1, pow(2, 11) - 1);
        $random = decbin(pow(2, 11) - 1 + $random);
        $base = $base . $machineID . $random;

        return bindec($base);
    }

    public static function timeFromSnowflake($id)
    {
        return bindec(substr(decbin($id), 0, 41)) - pow(2, 40) + 1 + self::EPOCH;
    }
}