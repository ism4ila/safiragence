@extends('layouts.app')

@section('content')
    <h1 class="my-4">Services</h1>
    <div class="list-group">
        @foreach ($services as $service)
            <a href="{{ route('services.show', $service) }}" class="list-group-item list-group-item-action">{{ $service->title }}</a>
        @endforeach
    </div>
@endsection