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
    class CategoryFilters extends QueryFilters
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
                ->where('name_ar', 'like', "%{$search}%")
                ->orWhere('name_en', 'like', "%{$search}%");
//            ->orWhere('description_ar', 'like', "%{$search}%")
//            ->orWhere('description_en', 'like', "%{$search}%")
//            ->orWhere('email', 'like', "%{$search}%");
//            ->orWhere('notes_ar', 'like', "%{$search}%")
//            ->orWhere('notes_en', 'like', "%{$search}%");
        }

        public function name($search)
        {
            return $this->builder
                ->where('name_ar', 'like', "%{$search}%")
                ->orWhere('name_en', 'like', "%{$search}%")
                ->orWhere('description_ar', 'like', "%{$search}%")
                ->orWhere('description_en', 'like', "%{$search}%");
        }


        public function on_home()
        {
            return $this->builder->where('on_home', request()->on_home);
        }

        public function on_new()
        {
            return $this->builder->where('on_new', request()->on_new);
        }

        public function is_parent()
        {
            return $this->builder->where('is_parent', request()->is_parent);
        }

        public function is_product()
        {
            return $this->builder->where('is_product', request()->is_product);
        }

        public function is_commercial()
        {
            return $this->builder->where('is_commercial', request()->is_commercial);
        }

        public function is_searchable()
        {
            return $this->builder->where('is_searchable', request()->is_searchable);
        }

        public function is_national_event()
        {
            return $this->builder->where('is_national_event', request()->is_national_event);
        }

        public function is_user()
        {
            return $this->builder->where('is_user', request()->is_user);
        }

        public function type()
        {
            return $this->builder->where(request()->type, true);
        }

        public function is_book()
        {
            return $this->builder->where('is_book', request()->is_book);
        }

        public function is_service()
        {
            return $this->builder->where('is_service', request()->is_service);
        }

        public function is_course()
        {
            return $this->builder->where('is_course', request()->is_course);
        }


        public function min()
        {
            return $this->builder->where('price', '>=', (double)request()->min);
        }

        public function max()
        {
            return $this->builder->where('price', '<=', (double)request()->max);
        }

        public function page()
        {
            return $this->builder;
        }

    }
