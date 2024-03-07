<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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

    public function toggleActivate(Request $request)
    {
        $validate = validator($request->all(), [
            "model" => "string|required",
            "id" => "integer|required"
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors()->first());
        }
        $className = "App\Models\\" . ucfirst($request->model);
        $element = new $className();
        $element = $element->whereId($request->id)->first();
        $element->update([
            "active" => !$element->active
        ]);
        return redirect()->back()->with("success", trans("general.process_success"));
    }
}
