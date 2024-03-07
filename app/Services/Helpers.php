<?php
/**
 * Created by PhpStorm.
 * User: usamaahmed
 * Date: 7/23/17
 * Time: 9:02 AM
 */

use App\Models\Area;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Setting;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Arr;


/**
 * @param $element
 */
function checkTrans($element)
{
    if (strpos(trans($element), 'message.') === 0 || strpos(trans($element), 'general.') === 0) {
        return null;
    }
    return trans($element);
}

/**
 * @param $element
 * @return null|string
 */
function activeItem($element, $another = [])
{
    if (strpos(Route::currentRouteName(), $element)) {
        return 'active open';
    }
    if (!empty($another)) {
        foreach ($another as $k => $value)
            if (strpos(Route::currentRouteName(), $value)) {
                return 'active open';
                break;
            }
    }
    return null;
}

function activeLabel($element)
{
    return $element ? 'label-success' : 'label-danger';
}

function activeBtn($element)
{
    return $element ? 'green' : 'red';
}

function activeText($element, $text = 'Active')
{
    $element ? $text = $text : $text = 'N/A';
    return $text;
}


function getCouponIsPercentage()
{
    if (session()->has('coupon')) {
        return Cart::instance('shopping')->content()->where('id', 'coupon')->first()->options->element->is_percentage;
        }
}

function getCouponValue()
{
    $coupon = session()->has('coupon') ? session()->get('coupon') : null;
    if (!is_null($coupon)) {
        return $coupon->is_percentage ? (Cart::instance('shopping')->total() * ($coupon->value / 100)) : $coupon->value;
    }
    return 0;
}


function getCartNetTotal()
{
    if (session()->has('coupon')) {
        $cartTotalVal = str_replace(',', '', Cart::instance('shopping')->total());
        return (float)$cartTotalVal - (float)getCouponValue();
    }
    return Cart::instance('shopping')->total();
}


function getDeliveryServiceCost()
{
    $settings = Setting::first();
    $cartValue = Cart::instance('shopping')->total();
    if ($cartValue >= $settings->delivery_service_minimum_charge) {
        return 0;
    }
    return $settings->delivery_service_cost;
}

function getCurrentCountry()
{
    if (!session()->has('country')) {
        $country = auth()->guest() ? Country::where(['is_local' => true])->first() : Country::whereId(auth()->user()->country_id)->first();
        session()->put('country', $country);
        return $country;
    }
    if (request()->header('country')) {
        return Country::where('country_code', request()->header('country'))->first();
    }
    return session()->get('country');
}

function getCurrentCurrency()
{
    if (session()->has('currency')) {
        return session()->get('currency');
    }
    if (request()->header('currency')) {
        return Currency::where('currency_symbol_en', request()->header('currency'))->first();
    }
    $currentCurrency = Currency::whereHas('country', function ($q) {
        return $q->where('is_local', true);
    })->first();
    session()->put('currency', $currentCurrency);
    return $currentCurrency;
}


function getConvertedPrice($price)
{
    $currentCurrency = getCurrentCurrency();
    return $price * $currentCurrency->exchange_rate;
}

function getCurrencySymbol()
{
    $currentCurrency = getCurrentCurrency();
    return $currentCurrency->currency_symbol_en;
}


function getDaySelected()
{
    return session()->get('day_selected');
}

function getDaySelected_format()
{
    return session()->get('day_selected_format');
}

function getTimingId()
{
    return session()->get('timing_id');
}

function getTimingValue()
{
    return session()->get('timing_value');
}

function get_client_ip()
{
    return request()->ip();
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function getClientCountry()
{
    // has no relation with Country of the session
//    $kwt = '188.70.48.243';
//    $ksa = '176.17.238.199';
//    $uae = '109.177.176.229';
//    if (app()->environment('local')) {
//    $user_ip = array_random(['188.70.48.243', '176.17.238.199', '109.177.176.229']);
//        $user_ip = array_random(['188.70.48.243']);
//    } else {
//        $user_ip = app()->isLocal() ? $kwt : get_client_ip();
//    }
//    $geo = unserialize(file_get_contents("https://www.geoplugin.net/php.gp?ip=$user_ip"));
//    $country = $geo["geoplugin_countryName"];
//    $city = $geo["geoplugin_city"];
//    $region = $geo["geoplugin_region"];
//    if ($country) {
//        $clientCountry = Country::where('name', $country)->first();
//        if ($clientCountry) {
//            auth()->check() ? User::where('id', auth()->id())->first()->update(['country_id' => $clientCountry->id]) : null;
//            $region ? session()->put('area', Area::where(['name' => $region])->first()) : null;
//            $city ? session()->put('city', $city) : null;
//        }
//        session()->put('country', $clientCountry);
//    } else {
//        $clientCountry = Country::where(['is_local' => true])->first();
//    }
    if (!session()->has('country')) {
        $country = auth()->guest() ? Country::where(['is_local' => true])->first() : Country::whereId(auth()->user()->country_id)->first();
        session()->put('country', $country);
    }
    if (request()->header('country')) {
        return Currency::where('country_code', request()->header('country'))->first();
    }
    // i want it to assign the country as null in case it's not included in the DB
//    dd(session()->get('country'));
    return session()->get('country');
}

function getCurrentCountrySessionId()
{
    return getClientCountry() ? getClientCountry()->id : null;
}

function checkShipmentAvailability($destinationCountryId, $destinationRangeIds)
{
    return in_array($destinationCountryId, $destinationRangeIds, true);
}

function getRequestQueryUrlWithout($element = '')
{
    return request()->url() . '?' . http_build_query(Arr::except(Request::query(), [$element, 'page']));
}

function numToEn($string) {
    return strtr($string, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
}

function pullLeft() {
    return app()->getLocale() === 'ar' ? 'pull-left' : 'pull-right';
}

