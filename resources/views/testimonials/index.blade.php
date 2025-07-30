@extends('layouts.app')

@section('content')
    <h1 class="my-4">Testimonials</h1>
    <div class="list-group">
        @foreach ($testimonials as $testimonial)
            <a href="{{ route('testimonials.show', $testimonial) }}" class="list-group-item list-group-item-action">{{ $testimonial->client_name }}</a>
        @endforeach
    </div>
@endsection