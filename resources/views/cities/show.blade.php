@extends('layouts.app')

@section('content')
    <h1 class="my-4">{{ $city->name }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Region:</strong> {{ $city->region }}</p>
            <p><strong>Country:</strong> {{ $city->country }}</p>
        </div>
    </div>
@endsection