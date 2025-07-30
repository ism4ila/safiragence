@extends('layouts.app')

@section('content')
    <h1 class="my-4">Cities</h1>
    <div class="list-group">
        @foreach ($cities as $city)
            <a href="{{ route('cities.show', $city) }}" class="list-group-item list-group-item-action">{{ $city->name }}</a>
        @endforeach
    </div>
@endsection