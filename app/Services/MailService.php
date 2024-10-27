<?php

namespace App\Services;

use App\Mail\TemplateMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * Undocumented function
     *
     * @param array|string $email
     * @param string $template_name
     * @param array<string> $placeholders
     * @param array<string> $attachmentInfo
     * @return void
     */
    static public function sendMailWithTemplate(array|string $email, string $template_name, array $placeholders = [], array $attachmentInfo = [])
    {
        try {
            $template = DB::table('email_templates')->where('template_name', $template_name)->first();
            if (!$template) {
                throw new \Exception("Template not found");
            }
            Mail::to($email)->send(new TemplateMail($template, $placeholders, $attachmentInfo));
        } catch (\Throwable $th) {
            Log::error("Failed to send email: " . $th->getMessage());
        }
    }
}
