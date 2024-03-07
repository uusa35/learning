<?php

namespace App\Services;

use App\Models\Color;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Size;
use App\Models\Timing;
use App\Models\User;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: usama
 * Date: 2019-03-11
 * Time: 08:27
 */
trait CartTrait
{
    public function addServiceToCart(Request $request, Service $service, $cart)
    {
        // Check all orders that may have metas with the same service and timing on the same date !!!
        if ($service->getCanBookAttribute(request('timing_id'), request('day_selected_format'))) {
            $element = $this->cart->content()->where('id', '=', $service->UId)->first();
            if ($element) {
                $this->cart->remove($element->rowId);
            }
            $this->cart->add($service->UId, $service->name, 1, $service->finalPrice, 1,
                [
                    'type' => 'service',
                    'element_id' => $service->id,
                    'collection_id' => $request->has('collection_id') ? $request->collection_id : null,
                    'day_selected' => Carbon::parse($request->day_selected_format),
                    'timing_id' => $request->timing_id,
                    'notes' => $request->notes,
                    'element' => $service,
                    'company' => $service->user->name,
                    'timing' => Timing::whereId($request->timing_id)->first()
                ]
            );
            return true;
        }
        return false;
    }

    public function addCountryToCart($country, $receiveFromBranch = false)
    {
        $element = \Gloudemans\Shoppingcart\Facades\Cart::instance('shopping')->content()->where('options.type', 'country')->first();
        $cart = \Gloudemans\Shoppingcart\Facades\Cart::instance('shopping');
        if ($element) {
            \Gloudemans\Shoppingcart\Facades\Cart::remove($element->rowId);
        }
        $settings = Setting::first();
        if ($settings->shipment_fixed_rate) {
            if (!$settings->multi_cart_merchant && $settings->global_custome_delivery) {

                $product = $cart->content()->where('options.type', 'product')->first();
                $user = $product ? User::whereId($product->options->element->user_id)->first() : null;
                if ($user && $user->custome_delivery) {
                    $cart->add($country->calling_code, trans('shipment_package_fee'), 1, (double)($country->is_local ? ($receiveFromBranch ? 0 : $user->custome_delivery_fees) : $this->getTotalItemsOnly($cart) * (double)$country->fixed_shipment_charge), 1, ['type' => 'country', 'country_id' => $country->id]);
                } else {
                    $cart->add($country->calling_code, trans('shipment_package_fee'), 1, (double)($country->is_local ? ($receiveFromBranch ? 0 : $country->fixed_shipment_charge) : $this->getTotalItemsOnly($cart) * (double)$country->fixed_shipment_charge), 1, ['type' => 'country', 'country_id' => $country->id]);
                }
            } else {
                if (env('MIRSAL_ENABLED')) {
                    $pickups = [];
                    foreach ($cart->content() as $item) {
                        $code = $item->options->element->user->localArea ? $item->options->element->user->localArea->code : null;
                        if (!is_null($code)) {
                            array_push($pickups, $code);
                        }
                    }
                    $authCode = auth()->user()->localArea ? auth()->user()->localArea->code : null;
                    if (!is_null($authCode)) {
                        array_push($pickups, $authCode);
                    }
                    $cost = $this->calculateDeliveryMultiPointsForMirsal($pickups);
                    $cost = $cost > 1 ? $cost : (double)$country->fixed_shipment_charge;
                    $cart->add($country->calling_code, trans('shipment_package_fee'), 1, (double)($country->is_local ? ($receiveFromBranch ? 0 : $cost) : $this->getTotalItemsOnly() * (double)$country->fixed_shipment_charge), 1, ['type' => 'country', 'country_id' => $country->id]);
                } else {
                    $cart->add($country->calling_code, trans('shipment_package_fee'), 1, (double)($country->is_local ? ($receiveFromBranch ? 0 : $country->fixed_shipment_charge) : $this->getTotalItemsOnly() * (double)$country->fixed_shipment_charge), 1, ['type' => 'country', 'country_id' => $country->id]);
                }
            }
        } else {
            $shipmentPackage = $country->shipment_packages()->first();
            $totalWeight = \Gloudemans\Shoppingcart\Facades\Cart::instance('shopping')->content()->sum('weight');
            \Gloudemans\Shoppingcart\Facades\Cart::instance('shopping')->add($country->calling_code, trans('shipment_package_fee'), 1, (double)$shipmentPackage->getFinalPrice($totalWeight), 1, ['type' => 'country', 'country_id' => $country->id]);
        }
    }

    public function addProductToCart(Request $request, Product $product)
    {
        if ($this->checkProduct($request, $product, $this->cart)) {
            $country = getClientCountry();
            $this->cart->add($product->getUniqueIdAttribute($request->product_attribute_id), $product->name, $request->qty, (double)$product->finalPrice, $request->qty * $product->weight,
                [
                    'type' => 'product',
                    'element_id' => $product->id,
                    'collection_id' => $request->has('collection_id') ? $request->collection_id : null,
                    // each product * his own package Charge ==> consider different heights / weight
                    'shipment_cost' => 0,
                    'country_destination' => $country,
                    'product_attribute_id' => $request->product_attribute_id,
                    'size_id' => $request->size_id,
                    'color_id' => $request->color_id,
//                    'color' => Color::whereId($request->color_id)->first(),
//                    'size' => Size::whereId($request->size_id)->first(),
                    'company' => $product->user->name,
                    'element' => $product
                ]
            );
            $this->addCountryToCart($country);
            return true;
        }
        return false;
    }

    public function checkProduct(Request $request, Product $product)
    {
        if ($product->getCanOrderAttribute($request->qty, $request->product_attribute_id)) {
            // if current product is direct_purachase make sure cart is 0
            // if current product is not direct_purachase make sure cart does not have direct_purchase
            $checkDirectPurchase = ($this->cart->content()->where('options.type', 'product')->count() === 0 && $product->direct_purchase) || ($this->cart->content()->where('options.element.direct_purchase', true)->count() === 0 && !$product->direct_purchase);
            if ($this->cart->content()->where('options.type', 'product')->count() > 0) {
                $multiVendor = Setting::first()->multi_cart_merchant; // False
                if (!$multiVendor && !in_array($product->user_id, $this->cart->content()->pluck('options.element.user_id')->toArray())) {
                    throw new \Exception(trans('message.this_cart_is_not_multi_vendor'));
                }
            }
            if ($checkDirectPurchase) {
                $element = $this->cart->content()->where('id', '=', $product->getUniqueIdAttribute($request->product_attribute_id))->first();
                if ($element) {
                    $this->cart->remove($element->rowId);
                }
                return true;
            } else {
            }
            // i removed this because shipment is not connected now to cart (only fixed prices)
//            if (checkShipmentAvailability(getCurrentCountrySessionId(), $product->shipment_package->countries->pluck('id')->toArray())) {
//            }
            throw new \Exception(trans('message.direct_purchase_product_cart'));
        }
        throw new \Exception(trans('message.product_out_of_stock'));
    }

    public function addCouponToCart(Request $request, Coupon $coupon)
    {
        if (session()->has('coupon')) {
            $element = $this->cart->content()->where('id', 'coupon')->first();
            if ($element) {
                $this->cart->remove($this->cart->content()->where('type', 'coupon')->first()->rowId);
                session()->remove('coupon');
            }
        }
        session()->put('coupon', $coupon);
        $couponValue = $coupon->is_percentage ? ($this->cart->total() * $coupon->value) / 100 : $coupon->value;
        if ($couponValue > 0) {
            $this->cart->add('coupon', 'coupon', 1, (float)-($couponValue), 1, [
                'type' => 'coupon',
                'element_id' => $coupon->id,
                'element' => $coupon
            ]);
            return true;
        }
        return false;
    }

    public function getTotalPriceOfProductsOnly()
    {
        return \Gloudemans\Shoppingcart\Facades\Cart::instance('shopping')->content()->where('options.type', 'product')->sum('price');
    }

    public function getTotalItemsOnly($cart)
    {
        return $cart->content()->where('options.type', 'product')->count();
    }

    public function calculateDeliveryMultiPointsForMirsal($pickups)
    {
        try {
            if (env('MIRSAL_ENABLED')) {
                $url = 'https://app.mirsal.co/rest/order/get-shipping-cost-multi-pickup';
                $access_key = 'JPBCMU3H747S';
                $prog_lang = 'Other';
                $pickups = array_values(array_unique($pickups));
                $requestData = json_encode($pickups);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, ['pickups' => $requestData, 'access_key' => $access_key, 'prog_lang' => $prog_lang]);
                $response = curl_exec($ch);
                curl_close($ch);
                $res = json_decode($response);
                return $res->shipping_cost;
            }
        } catch (\Exception $e) {
            abort('404', $e->getMessage());

        }
    }
}
