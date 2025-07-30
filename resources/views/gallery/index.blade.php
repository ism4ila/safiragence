@extends('layouts.app')

@section('content')
    <h1 class="my-4">Gallery</h1>
    <div class="row">
        @foreach ($images as $image)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <a href="{{ route('gallery.show', $image) }}">
                        <img src="{{ asset($image->image_path) }}" class="card-img-top" alt="{{ $image->title }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">{{ $image->title }}</h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection