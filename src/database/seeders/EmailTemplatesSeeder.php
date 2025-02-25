<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'template_name' => 'Self skill',
                'subject' => 'Self Skill',
                'body' => 'Dear {FIRST_NAME} ,<br><br>You have requested to increase your skill up. Click <a href="{RESET_LINK}">here</a>
                <p>self skill</p>
                <p>1230 Dhaka Bangladesh,
                    <br>
                    Mohakhali Dhaka
                </p>
                <p>Email: hafizpustice05@gmail.com | Phone: (+880) 01580383905</p>
                </div>
                ',
                'available_variables' => json_encode(['FIRST_NAME', 'LAST_NAME', 'RESET_LINK'])
            ]
        ];

        foreach ($templates as $template) {
            DB::table("email_templates")->insert($template);
        }
    }
}
