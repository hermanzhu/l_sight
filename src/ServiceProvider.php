<?php
/**
 * Created by PhpStorm.
 * User: zhushiya
 * Date: 11/14/15
 * Time: 9:33 PM
 */

namespace Insight;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    protected $defer = false;

    public function register()
    {
//        dump('register');
    }

    public function boot()
    {
//        dump('boot');
    }
}