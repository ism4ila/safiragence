@extends('layouts.app')

@section('content')
    <h1 class="my-4">{{ $image->title }}</h1>
    <div class="card">
        <img src="{{ asset($image->image_path) }}" class="card-img-top" alt="{{ $image->title }}">
        <div class="card-body">
            <p class="card-text">{{ $image->description }}</p>
        </div>
    </div>
@endsection