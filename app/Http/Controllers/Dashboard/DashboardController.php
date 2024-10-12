<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsUrl;
use App\Models\MappingUrl;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Undocumented function
     *
     * @return View
     */
    public function dashboard(): View
    {
        $urls = MappingUrl::with("analyticsUrls")->orderBy("id", "desc")->paginate(10);
        return view('dashboard', compact('urls'));
    }

    /**
     * Undocumented function
     *
     * @param string $shortUrl
     * @return View
     */
    public function analyticsUrl(string $shortUrl): View
    {
        $url = MappingUrl::where('shortened_url', $shortUrl)->first();

        if (!$url) {
            return redirect()->back();
        }

        $analyticsUlrs = AnalyticsUrl::where("mapping_url_id", $url->id)->orderBy("id", "desc")->paginate(10);
        return view('analytics-url', compact('analyticsUlrs', 'url'));
    }
}
