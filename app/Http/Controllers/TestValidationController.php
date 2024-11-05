<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestValidationController extends Controller
{
    function index(Request $request)
    {
        $request->validate([
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|integer',
            'status' => 'required|in:approved,pending,rejected', // Ensure status is one of the expected values
            'image' => 'required_if:status,approved|image|mimes:jpg,jpeg,png,gif|max:2048', // Image is required if status is approved


            "ss" => "fff"
        ]);
    }
}
