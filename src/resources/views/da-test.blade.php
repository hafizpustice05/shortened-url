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

        {{ $urls->links('pagination::tailwind') }}
    </div>
@endsection
