@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <h3>Shortend URL: {{ config('app.url').'/'.$url->shortened_url}}</h3>
    </div>

    <table class="table table-hover">

        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Visitor IP</th>
                <th scope="col">Country</th>
                <th scope="col">Region</th>
                <th scope="col">City</th>
                <th scope="col">Visited At</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($analyticsUlrs as $item)
            <tr>
                <td>{{ ($analyticsUlrs->currentPage() - 1) * $analyticsUlrs->perPage() + $loop->index + 1 }}</td>

                <td>
                    {{ $item->visitor_IP }}
                </td>
                <td>{{$item->country}}</td>
                <td>{{$item->region}}</td>
                <td>{{$item->city}}</td>
                <td>{{\Carbon\Carbon::parse($item->visited_at)->diffForHumans()}}</td>

            </tr>
            @empty
            <tr>
                <th colspan="6" class="text-center">There are no click details right now</th>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $analyticsUlrs->links() }}
</div>
@endsection
