<?php

namespace App\Services\Traits;
use App\Models\Setting;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;

/**
 * Created by PhpStorm.
 * User: usama
 * Date: 9/27/18
 * Time: 1:18 PM
 */
trait NotificationHelper
{
    function notify($headings, $descritpion, $url = null, Request $request)
    {
        try {
            $settings = Setting::first();
            $fields = array(
                'app_id' => env('ONE_SIGNAL_APP_ID'),
                'included_segments' => array('Active Users'),
//            'include_player_ids' => ['b6c053e7-4083-4ee5-a430-7d4b6e6911fd'],
                'headings' => [
                    'en' => strip_tags($headings),
                    'ar' => strip_tags($headings),
                ],
//            'subtitle' => [
//                'en' => trans('message.notification_message', ['appName' => env('APP_NAME')]),
//                'ar' => trans('message.notification_message', ['appName' => env('APP_NAME')]),
//            ],
                'app_url' => $url,
//            https://i-stores.store/element/linking?model=user&id=6&type=designer (latest)
//            'web_url' => 'https://abati.ideasowners.net/element/linking?is_product=1&id=8',
//            'web_url' => $url,
                'data' => $request ? ['model' => $request->notificationable_type, 'id' => $request->notificationable_id] : [],
                'contents' => [
                    'en' => strip_tags($descritpion),
                    'ar' => strip_tags($descritpion)
                ],
                'ios_attachments' => ["id" => $settings->LogoThumb],
                'big_picture' => $settings->LogoThumb
            );

            $fields = json_encode($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                'Authorization: Basic ' . env('ONE_SIGNAL_REST_ID')));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
//            if(json_decode($response)->errors && !app()->environment('production')) {
//                dd(json_decode($response)->errors);
//            }
            curl_close($ch);
            return $response;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }


    function notifyModal($headings, $descritpion, $url = null, $element = null)
    {
        $fields = array(
            'app_id' => env('ONE_SIGNAL_APP_ID'),
            'included_segments' => array('Active Users'),
//            'include_player_ids' => ['d4c0adab-45e1-45c1-ba7e-d85af28d85a9'],
            'headings' => [
                'en' => strip_tags($headings),
                'ar' => strip_tags($headings),
            ],
//            'subtitle' => [
//                'en' => trans('message.notification_message', ['appName' => env('APP_NAME')]),
//                'ar' => trans('message.notification_message', ['appName' => env('APP_NAME')]),
//            ],
            'app_url' => $url,
//            https://i-stores.store/element/linking?model=user&id=6&type=designer (latest)
//            'web_url' => 'https://abati.ideasowners.net/element/linking?is_product=1&id=8',
//            'web_url' => $url,
            'data' => $element ? ['element' => $element] : [],
            'contents' => [
                'en' => strip_tags($descritpion),
                'ar' => strip_tags($descritpion)
            ],
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . env('ONE_SIGNAL_REST_ID')));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }

    public function sendVerificationCode($fullMobile,$code) {
        Nexmo::message()->send([
            'to' => $fullMobile,
            'from' => env('APP_NAME'),
            'text' => 'Welcome to ' .env('APP_NAME'). ' your verification code is : '. $code .' - '
        ]);
    }
}
