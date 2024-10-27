<?php

namespace App\Http\Controllers;

use App\Services\MailService;
use Illuminate\Http\Request;

class TestMailController extends Controller
{
    public function index(Request $request)
    {

        $file = $request->file('picture');
        // Get the original file name (with extension)
        $originalName = $file->getClientOriginalName();
        // Get extension
        $extension = $file->getClientOriginalExtension();

        $attachmentInfo = [
            // "path" => storage_path("app/public/{$stored}"),
            "path" => $request->file('picture'),
            "as" => $originalName,
            "withMime" => "image/{$extension}",
        ];

        $placeHolders = [
            'FIRST_NAME'  => "Md. hafizul Islam",
            'EMAIL' => "hafiz",
            'PASSWORD' => "123",
            'ROLE' => "34",
            'LOGIN_URL' => "4545"
        ];

        MailService::sendMailWithTemplate("test@gmail.com", "collected", $placeHolders,  $attachmentInfo);
    }
}
