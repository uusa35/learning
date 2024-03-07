<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function changeLang($lang)
    {
        if (!in_array($lang, ["en", "ar"])) {
            abort(400);
        }
        app()->setLocale($lang);
        session()->put("lang", $lang);
        request()->setLocale($lang);
        Carbon::setLocale($lang);
        return redirect()->back();
    }
}
