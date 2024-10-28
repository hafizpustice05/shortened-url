<?php

namespace App\Http\Controllers;

use App\Services\NotificationSetting;
use Illuminate\Http\Request;

class TestNotificationSettingController extends Controller
{
    function index(): mixed
    {
        $settings = NotificationSetting::STATUS_CODES;

        $arr = [
            "EMAIL" => false,
            "SMS" => true,
        ];
        $userSetting = [];


        foreach ($settings as $key => $index) {
            $userSetting[$index] = $arr;
        }
        $userSetting[NotificationSetting::BIDDER_TOPIC_3];

        $encode = \json_encode($userSetting);

        return json_decode($encode, true)[NotificationSetting::BIDDER_TOPIC_3]["EMAIL"];
    }
}
