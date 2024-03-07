<?php

namespace App\Services\Search;

use App\Http\Resources\CategoryLightResource;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: usamaahmed
 * Date: 2/7/17
 * Time: 8:40 AM
 */
class Filters extends QueryFilters
{
    public $category;

    public function __construct(Request $request, Category $category)
    {
        parent::__construct($request);
        $this->category = $category;
    }


    public function search($search)
    {
        return $this->builder
            ->where('id', 'like', "%{$search}%")
            ->orWhere('sku', 'like', "%{$search}%")
            ->orWhere('name_ar', 'like', "%{$search}%")
            ->orWhere('name_en', 'like', "%{$search}%")
            ->orWhere('description_ar', 'like', "%{$search}%")
            ->orWhere('description_en', 'like', "%{$search}%");
    }

    public function name($search)
    {
        return $this->builder
            ->where('name_ar', 'like', "%{$search}%")
            ->orWhere('name_en', 'like', "%{$search}%")
            ->orWhere('description_ar', 'like', "%{$search}%")
            ->orWhere('description_en', 'like', "%{$search}%");
    }


    public function category_id()
    {
        return $this->builder->whereHas('categories', function ($q) {
            return $q->whereIn('category_id', is_array(request()->category_id) ? request()->category_id : [request()->category_id]);
        });
    }

    public function users()
    {
        return $this->builder->whereIn('user_id', request()->users);
    }

    public function user_id()
    {
        return $this->builder->where(['user_id' => request()->user_id]);
    }

    public function tag_id()
    {
        return $this->builder->whereHas('tags', function ($q) {
            return $q->where('tag_id', request()->tag_id);
        });
    }


    public function hot_deal()
    {
        return $this->builder->where('is_hot_deal', true)->whereDate('end_sale', '>', Carbon::now());
    }

    public function free()
    {
        return $this->builder->where('free', request()->free);
    }

    public function min()
    {
        return $this->builder->where('price', '>=', (float)request()->min);
    }

    public function max()
    {
        return $this->builder->where('price', '<=', (float)request()->max);
    }


    public function page()
    {
        return $this->builder;
    }

    public function on_home()
    {
        return $this->builder->where('on_home', request()->on_home);
    }

    public function on_new()
    {
        return $this->builder->where('on_new', request()->on_new);
    }

    public function is_hot_deal()
    {
        return $this->builder->where('is_hot_deal', request()->is_hot_deal);
    }

    public function exclusive()
    {
        return $this->builder->where('is_hot_deal', request()->exclusive);
    }

    public function is_available()
    {
        return $this->builder->where('is_available', request()->is_available);
    }

    public function active()
    {
        return $this->builder->where('active', request()->active);
    }

    public function on_sale()
    {
        return $this->builder->where('on_sale', request()->on_sale);
    }

    public function slidable_id()
    {
        return $this->builder->where('slidable_id', request()->slidable_id);
    }

    public function slidable_type()
    {
        return $this->builder->where('slidable_type', 'App\Models\\' . ucfirst(request()->slidable_type));
    }

    public function taggable_id()
    {
        return $this->builder->where('taggable_id', request()->taggable_id);
    }

    public function taggable_type()
    {
        return $this->builder->where('taggable_type', 'App\Models\\' . ucfirst(request()->taggable_type));
    }

    public function slug()
    {
        return $this->builder;
    }

    public function is_hotel()
    {
        return $this->builder->where('is_hote', request()->is_hotel);
    }
    public function is_company()
    {
        return $this->builder->where('is_company', request()->is_company);
    }
    public function is_restaurant()
    {
        return $this->builder->where('is_restaurant', request()->is_restaurant);
    }

    public function order()
    {
        return $this->builder;
    }
}
