<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

class Controller extends \Aphly\Laravel\Controllers\AdminController
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
        parent::__construct();
    }


}
