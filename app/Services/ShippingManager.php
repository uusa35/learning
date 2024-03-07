<?php

namespace App\Services;

use App\Models\Country;
use Carbon\Carbon;
use Exception;

trait ShippingManager
{
    public function calculateCost($cartWeight,$country,$area)
    {
        $destinationCountry = Country::whereId($country)->first();
        $deliveryCost = $this->calcRateAramex($destinationCountry, $cartWeight,$area);
        return $deliveryCost;
    }

    public function calcRateAramex($destinationCountry, $cartWeight,$area)
    {
        $params = array(
            'ClientInfo' => [
                "UserName" => env('ARAMEX_USERNAME'),
                "Password" => env('ARAMEX_PASSWORD'),
                "Version" => "v2.0",
                "AccountNumber" => env('ARAMEX_ACCOUNT_NUMBER'),
                "AccountPin" => env('ARAMEX_ACCOUNT_PIN'),
                "AccountEntity" => env('ARAMEX_ACCOUNT_ENTITY'),
                "AccountCountryCode" => env('ARAMEX_ACCOUNT_COUNTRY_CODE'),
            ],
            'Transaction' => array(
                'Reference1' => '001'
            ),
            'OriginAddress' => array(
                "City" => env('ORIGINAL_CITY'),
                "CountryCode" => env('ORIGINAL_COUNTRY')
            ),
            'DestinationAddress' => array(
                "City" => $area,
                "CountryCode" => $destinationCountry->code
//                "CountryCode" => $destinationCountry->iso_3166_2
            ),
            'Shipping Date' => Carbon::today(),
            'ShipmentDetails' => array(
                'PaymentType' => 'P',
                'ProductGroup' => ($destinationCountry->country_iso_alpha3 == 'KW') ? 'DOM' : 'EXP',
                'ProductType' => ($destinationCountry->country_iso_alpha3 == 'KW') ? 'ONP' : 'EPX',
                'ActualWeight' => array('Value' => $cartWeight, 'Unit' => 'KG'),
                'ChargeableWeight' => array('Value' => $cartWeight, 'Unit' => 'KG'),
                'NumberOfPieces' => 1
            )
        );
        $country = [
            'ClientInfo' => [
                "UserName" => env('ARAMEX_USERNAME'),
                "Password" => env('ARAMEX_PASSWORD'),
                "Version" => "v2.0",
                "AccountNumber" => env('ARAMEX_ACCOUNT_NUMBER'),
                "AccountPin" => env('ARAMEX_ACCOUNT_PIN'),
                "AccountEntity" => env('ARAMEX_ACCOUNT_ENTITY'),
                "AccountCountryCode" => env('ARAMEX_ACCOUNT_COUNTRY_CODE'),
                'Source' => NULL
            ],
            'Transaction' => [
                'Reference1' => '001',
            ],
            'Code' => $destinationCountry->country_iso_alpha3 ,
        ];
        try {
            $countriesSoapClient = new \SoapClient(env('ARAMEX_COUNTRY_URL'), array('trace' => 1));
            $country = $countriesSoapClient->FetchCountry($country);
            if (!is_null($country->Country->Name)) {
                $calcSoapClient = new \SoapClient(env('ARAMEX_CALC_URL'), array('trace' => 1));
                $results = $calcSoapClient->CalculateRate($params);
                if($results->HasErrors) {
                    return 0;
                    throw  new \Exception($results->Notifications->Notification->Message);
                }
                return $results->TotalAmount->Value;
            }
        } catch (SoapFault $fault) {
            throw new \Exception("Shipping to {$destinationCountry->name} is not available");
        }
    }
}


