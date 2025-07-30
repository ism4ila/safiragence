@extends('layouts.app')

@section('content')
    <h1 class="my-4">{{ $service->title }}</h1>
    <div class="card">
        <div class="card-body">
            {!! $service->description !!}
        </div>
    </div>
@endsection