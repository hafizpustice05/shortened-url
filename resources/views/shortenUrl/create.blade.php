@extends('layouts.app')

@section('title', 'Create url')

@section('content')
<div class="container">

    <h3 class="mb-1">Basic Url rules: </h3>

    <div>
        <ul>
            <li>url: Ensures that you have to follow a valid URL format (e.g., http://example.com or
                https://example.com).</li>
            <li>active_url: Your Urls have to ensure the domain exists and is active (does a DNS lookup).</li>
        </ul>
    </div>

    <div class="mt-5">
        <form action="{{route('shortenurl')}}" method="POST">
            @csrf

            <div class="mb-3 form-group">
                <label for="longUrl" class="form-label">Long Url</label>
                <input type="text" name="long_url" placeholder="http://example.com"
                    class="form-control @error('long_url') is-invalid @enderror">

                @error('long_url')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

            </div>

            <div class="float-right">
                <button type="submit" class="btn btn-primary">Save</button>

            </div>
        </form>
    </div>

    @if (old('shortendUrl'))
    <div class="mt-5">
        <div class="form-group">
            <label for="">Shortend Ulr</label>
            <textarea name="" id="shortend_url" class="form-control disabled">{{old('shortendUrl')}}</textarea>
        </div>
    </div>
    @endif
</div>

@endsection