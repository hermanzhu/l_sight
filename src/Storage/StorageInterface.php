<?php
/**
 * Created by PhpStorm.
 * User: zhushiya
 * Date: 12/24/15
 * Time: 5:16 PM
 */

namespace Insight\Storage;

use Insight\Collections;

interface StorageInterface
{
    public function store(Collections $collections);

    public function retrieve($id = '');
}