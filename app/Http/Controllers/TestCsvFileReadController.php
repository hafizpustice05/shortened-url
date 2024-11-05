<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TestCsvFileReadController extends Controller
{
    public function _index()
    {
        $filePath = public_path('admin/seed_files/email_body.csv');

        if (($handle = fopen($filePath, 'r')) !== false) {
            // Get the first row as headers
            $headers = fgetcsv($handle, 1000, ','); // Change ',' to your delimiter if needed

            // Loop through the rest of the file to get the data
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // Combine headers with row values
                $data[] = array_combine($headers, $row);
            }

            // Close the file
            fclose($handle);
        }

        foreach ($data as $item) {
            DB::table('email_templates')->insert([
                'id'                  => $item['id'] ?? null,
                'template_number'     => $item['template_number'] ?? null,
                'template_name'       => $item['template_name'] ?? null,
                'subject'             => $item['subject'] ?? null,
                'body'                => $item['body'] ?? null,
                'available_variables' => $item['available_variables'] ?? null
            ]);
        }
    }
}
