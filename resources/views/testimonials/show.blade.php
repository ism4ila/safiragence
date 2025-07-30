@extends('layouts.app')

@section('content')
    <h1 class="my-4">{{ $testimonial->client_name }}</h1>
    <div class="card">
        <div class="card-body">
            <p class="card-text">{{ $testimonial->content }}</p>
        </div>
    </div>
@endsection