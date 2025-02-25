<?php

namespace App\Services;

class NotificationSetting
{

    public const BIDDER_TOPIC_0 = 100;
    public const BIDDER_TOPIC_1 = 101;
    public const BIDDER_TOPIC_2 = 102;
    public const BIDDER_TOPIC_3 = 103;

    public const STATUS_CODES = [
        "100" => "BIDDER_TOPIC_0",
        "101" => "BIDDER_TOPIC_1",
        "102" => "BIDDER_TOPIC_2",
        "103" => "BIDDER_TOPIC_3"
    ];
}
