<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function __invoke()
    {
        return view('admin.settings.index');
    }
}
