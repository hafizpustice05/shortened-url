<?php

namespace App\Http\Controllers\ShortendUrl;

use App\Http\Controllers\Controller;
use App\Models\MappingUrl;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ShortendUrlController extends Controller
{
    /**
     * Undocumented variable
     * How many days url will have valid
     * @var integer
     */
    protected $urlExpiredDays = 30;

    public function create(): View
    {
        $urls = MappingUrl::get();
        return view("shortenUrl.create", compact('urls'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'long_url' => ['required', 'url', 'active_url', 'regex:/^(http|https):\/\//', 'max:2024'],
        ], [
            'long_url.required' => 'Please provide a URL.',
            'long_url.url' => 'Enter a valid URL format.',
            'long_url.regex' => 'The URL must begin with either http or https.',
            'long_url.max' => 'The URL can be up to :max characters long.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /**
         * basic sanitization and extra validation for malicious url
         */
        $validUrl = $this->basicSanitizeUrl($request->long_url);
        if (empty($validUrl)) {
            $request->errors()->add('long_url', 'your long-url not valid');
            return \redirect()->back()->withErrors($validator)->withInput();
        }

        /**
         * URL dublication check
         * IF url duplicate returns same shortend url
         */
        $existingUrl = $this->urlDuplicationCheck($validUrl);
        if (empty($existingUrl)) {
            /**
             * md5 return 32 length unique character string
             * @var string shortenedUrl = 0a97095fbaae58a3df4cb43544c82e2a
             */
            $shortenedUrl = md5($validUrl . time());
            try {
                $url = MappingUrl::create([
                    'long_url' => $validUrl,
                    'shortened_url' => $shortenedUrl,
                    'expired_at' => (Carbon::now())->addDays($this->urlExpiredDays),
                ]);
                $request->merge(["shortendUrl" => config('app.url') . '/' . $url->shortened_url]);
                return redirect()->back()->withInput()->with('success', 'Your shortend url generated successfully.');
            } catch (\Throwable $th) {
                Log::error("Shorting ulr error: " . $th->getMessage());
                return redirect()->back()->with('error', $th->getMessage());
            }
        }
        $request->merge(["shortendUrl" => config('app.url') . '/' . $existingUrl]);
        return redirect()->back()->withInput()->with('warning', 'You have already added this url.');
    }

    public function urlDuplicationCheck(string $longUrl): string
    {
        $url = MappingUrl::where('long_url', $longUrl)->first();
        Log::debug($url);
        if ($url) {
            return $url->shortened_url;
        }
        return '';
    }

    public function basicSanitizeUrl(string $inputLongUrl): null|string
    {
        $sanitizedUrl = filter_var($inputLongUrl, FILTER_SANITIZE_URL);
        if (!filter_var($sanitizedUrl, FILTER_VALIDATE_URL)) {
            return null;
        }

        /**
         * The pattern (?<!:)//+ ensures that double slashes after the protocol (http:// or https://)
         * are not replaced, but any other double slashes are replaced with a single slash.
         * @var string longUrl=https://laravel.com/docs/11.x/blade#stacks/
         */
        $longUrl = preg_replace('#(?<!:)//+#', '/', $sanitizedUrl);

        /**
         * '/\/$/' this pattern remove last slash from the url, it's not necessary
         * but it provide a more valid url
         * @var string longUrl=https://laravel.com/docs/11.x/blade#stacks
         */
        return $longUrl = rtrim($longUrl, '/\/$/');
    }
}
