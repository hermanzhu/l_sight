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
    public function fuzzyPassword(array $data)
    {
        foreach ($data as $k => &$v) {
            if ((strpos($k, 'pass') !== false)) {
                $v = '**fuzzy**';
            }
        }
        return $data;
    }

    public function removeElementsFromArray(array $data, array $rubbish)
    {
        if (count($rubbish) === 0) {
            return $data;
        }
        foreach ($rubbish as $item) {
            if (isset($data[$item])) {
                unset($data[$item]);
            }
        }
        return $data;
    }

    public function removeObjectAndNil(array $data)
    {
        if (count($data) === 0) {
            return $data;
        }
        foreach ($data as $k => &$v) {
            if (is_object($v)) {
                $v = get_class($v);
            }
            if (empty($v)) {
                $v = 'nil';
            }
            if (is_array($v)) {
                $v = $this->removeObjectAndNil($v);
            }
        }
        return $data;
    }

}