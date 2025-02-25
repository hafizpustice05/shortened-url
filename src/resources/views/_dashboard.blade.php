@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

        </div>

        <table class="table table-hover">

            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Shortener-URL</th>
                    <th scope="col">Long-Url</th>
                    <th scope="col">Expired At</th>
                    <th scope="col">Clicks</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($urls as $index => $item)
                    <tr>
                        <td>{{ ($urls->currentPage() - 1) * $urls->perPage() + $index + 1 }}</td>

                        <td>
                            <a href="{{ url($item->shortened_url) }}">{{ env('APP_URL') . '/' . $item->shortened_url }}</a>
                        </td>
                        <td>{{ substr($item->long_url, 0, 20) }}...</td>
                        <td>{{ $item->expired_at }}</td>
                        <td>{{ $item->click_count }}</td>
                        <td>
                            <a href="{{ route('dashboard.analytics-url', $item->shortened_url) }}">
                                Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <th colspan="6" class="text-center">Shortend URL record is empty</th>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div>
            <iframe
                src="http://127.0.0.1:8000/dae/show-ads?publisher_id=b897c8e787a76944d886e0b4076dd4773bc2937c3ccc9410a459128b393e5a02&type=video&size=video&district=Dhaka&upazila=Dhaka%20%28City%29&zone=DHAKA&callback=0&campaign=25"
                scrolling="no" marginwidth="0" marginheight="0" style="border: 0px none; vertical-align: middle;"
                aria-label="Advertisement" tabindex="0" width="320" height="180" frameborder="0"></iframe>
        </div>

        <div class="center">
            <iframe
                src="http://127.0.0.1:8000/dae/show-ads?publisher_id=b897c8e787a76944d886e0b4076dd4773bc2937c3ccc9410a459128b393e5a02&type=video&size=video&district=Dhaka&upazila=Dhaka%20%28City%29&zone=DHAKA&callback=0&campaign=0"
                scrolling="no" marginwidth="0" marginheight="0" style="border: 0px none; vertical-align: middle;"
                aria-label="Advertisement" tabindex="0" width="320" height="180" frameborder="0"></iframe>
        </div>
        
        <div style="float: right;">
<iframe src="http://127.0.0.1:8000/dae/show-ads?publisher_id=b897c8e787a76944d886e0b4076dd4773bc2937c3ccc9410a459128b393e5a02&type=video&size=video&district=Dhaka&upazila=Dhaka%20%28City%29&zone=DHAKA&callback=0&campaign=0" scrolling="no" marginwidth="0" marginheight="0" style="border: 0px none; vertical-align: middle;"  aria-label="Advertisement" tabindex="0" width="320" height="180" frameborder="0"></iframe>
</div>


        {{ $urls->links('pagination::tailwind') }}
    </div>
@endsection
