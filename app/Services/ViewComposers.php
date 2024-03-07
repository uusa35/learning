<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\Page;
use App\Models\Country;
use App\Models\Field;
use App\Models\Group;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Role;
use App\Models\ShipmentPackage;
use App\Models\Size;
use App\Models\Slide;
use App\Models\Timing;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Cache as Cache;
use Illuminate\View\View;

class ViewComposers
{


    public function getSlides(View $view)
    {
        $slides = Slide::active()->get();
        return $view->with(compact('slides'));
    }

    public function getPages(View $view)
    {
        $pages = Page::active()->orderBy('order', 'asc')->get();
        return $view->with(compact('pages'));
    }

    public function getMenus(View $view)
    {
        $menus = Menu::active()->onlyParent()->with('children','page')->orderBy('order', 'asc')->get();
        return $view->with(compact('menus'));
    }

    public function getSettings(View $view)
    {
        $settings = Setting::first();
        return $view->with(compact('settings'));
    }

    public function getServices(View $view)
    {
        $services = Service::active()->orderBy('order','desc')->get();
        return $view->with(compact('services'));
    }

    public function getFaqs(View $view) {
        $faqs = Faq::active()->get();
        return $view->with(compact('faqs'));
    }
}

