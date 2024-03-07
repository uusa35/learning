<?php

namespace App\Services\Search;

use App\Http\Resources\CategoryLightResource;
use App\Models\Collection;

/**
 * Created by PhpStorm.
 * User: usamaahmed
 * Date: 2/7/17
 * Time: 8:40 AM
 */
class TranslationFilters extends QueryFilters
{
    public function search($search)
    {
        return $this->builder
            ->where('ar', 'like', "%{$search}%")
            ->orWhere('en', 'like', "%{$search}%")
            ->orWhere('key', 'like', "%{$search}%");
    }

    public function page()
    {
        return $this->builder;
    }
}
