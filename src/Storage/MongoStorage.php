<?php
/**
 * Created by PhpStorm.
 * User: zhushiya
 * Date: 12/24/15
 * Time: 5:20 PM
 */

namespace Insight\Storage;

use DB;
use Insight\Collections;

class MongoStorage implements StorageInterface
{

    protected $table = 'latest';

    public function __construct()
    {
        $this->collection = env('INSIGHT_CONNECTION', 'mongodb');
    }

    public function store(Collections $collections)
    {
        DB::connection($this->collection)->collection($this->table)
            ->insert($collections->asArray());
    }

    public function retrieve($id = '')
    {
        $model = DB::connection($this->collection)->collection($this->table)->where('uid', $id)->first();
        if(empty($model)){
            $model = DB::connection($this->collection)->collection($this->table)->first();
        }
        return $model;
    }

}