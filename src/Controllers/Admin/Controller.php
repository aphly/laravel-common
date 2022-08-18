<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Illuminate\Support\Facades\View;

class Controller extends \Aphly\LaravelAdmin\Controllers\Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
        parent::__construct();
    }
}
