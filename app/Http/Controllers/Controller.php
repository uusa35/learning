<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    const TAKE_LARGE = 50;
    const TAKE_MID = 24;
    const TAKE_LESS = 12;
    const TAKE_MIN = 6;
}
