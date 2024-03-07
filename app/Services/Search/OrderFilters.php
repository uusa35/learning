<?php

namespace App\Services\Search;

use App\Http\Resources\CategoryLightResource;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: usamaahmed
 * Date: 2/7/17
 * Time: 8:40 AM
 */
class OrderFilters extends QueryFilters
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function search($search)
    {
        return $this->builder
            ->where('id', 'like', "%{$search}%")
            ->orWhere('price', 'like', "%{$search}%")
            ->orWhere('net_price', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('address', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            ->orWhere('mobile', 'like', "%{$search}%")
            ->orWhere('country', 'like', "%{$search}%");
    }

    public function paid()
    {
        return $this->builder->where(['paid' => request()->paid]);
    }

    public function status()
    {
        return $this->builder->where('status', '=' , request()->status);
    }

    public function cash_on_delivery()
    {
        return $this->builder->where(['cash_on_delivery' => true]);
    }

    public function receive_on_branch()
    {
        return $this->builder->where(['receive_on_branch' => true]);
    }

    public function payment_method()
    {
        return $this->builder->where(['paid' => true, 'cash_on_delivery' => false]);
    }


    public function active()
    {
        return $this->builder->where(['status' => 'paid']);
    }


    public function page()
    {
        return $this->builder;
    }

    public function created_at($date)
    {
        return $this->builder->whereDate('created_at', '>=', Carbon::parse($date));
    }

}
