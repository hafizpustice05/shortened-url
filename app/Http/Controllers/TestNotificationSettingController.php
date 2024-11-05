<?php

namespace App\Http\Controllers;

use App\Services\NotificationSetting;

class TestNotificationSettingController extends Controller
{
    public static function index(): mixed
    {
        $settings = NotificationSetting::STATUS_CODES;

        $arr = [
            'EMAIL' => false,
            'SMS'   => true
        ];

        foreach ($settings as $key => $index) {
            $userSetting[$key] = $arr;
        }

        // return $userSetting[NotificationSetting::BIDDER_TOPIC_3];

        return $encode = json_encode($userSetting, JSON_PRETTY_PRINT);

        return json_decode($encode, true)[NotificationSetting::BIDDER_TOPIC_3]['EMAIL'];
    }
}
