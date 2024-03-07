<?php
/**
 * Created by PhpStorm.
 * User: usamaahmed
 * Date: 2/7/17
 * Time: 8:42 AM
 */
namespace App\Services\Search;


use App\Http\Requests\Frontend\HomePageSearch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilters
{
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filters()
    {
//        dd($this->request->all());
        $removeNull = array_filter($this->request->except('_token','page'), function ($value) {
            if (!is_null($value)) {
                return $value;
            }
        });
        return $removeNull;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        if (is_null($this->filters())) {
            abort(505, trans('message.search_not_correct'));
        }

        foreach ($this->request->all() as $key => $value) {

            call_user_func_array([$this, $key], array_filter([$value]));
        }

        return $this->builder;
    }

}
