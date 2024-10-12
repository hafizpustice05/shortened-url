<?php

namespace App\Http\Controllers;

use App\Models\MappingUrl;
use App\Services\IGeographicalLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UrlRedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($shortenedUrl, Request $request, IGeographicalLocation $iGeographicalLocation)
    {
        $url = MappingUrl::where('shortened_url', $shortenedUrl)->first();

        /**
         * IF No Shortend url found in the model
         */
        if (empty($url)) {
            abort(Response::HTTP_NOT_FOUND, 'This link not found.');
        }

        /**
         * IF this shortend url is expired
         */
        if (Carbon::createFromDate($url->expired_at)->isPast()) {
            abort(Response::HTTP_FORBIDDEN, 'This link has expired.');
        }

        /**
         *
         * IF this shortend is valid
         * Save geographical location data based on IP address
         */
        $iGeographicalLocation->saveUserGeographicalLocationData($url, $request->ip());
        $url->increment('click_count');

        return redirect()->away($url->long_url);
    }
}
