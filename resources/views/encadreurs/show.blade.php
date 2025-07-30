@extends('layouts.app')

@section('content')
    <h1 class="my-4">{{ $encadreur->full_name }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Email:</strong> {{ $encadreur->email }}</p>
            <p><strong>Phone:</strong> {{ $encadreur->phone_1 }}</p>
            <p><strong>Specialties:</strong> {{ $encadreur->specialties }}</p>
            <p><strong>Notes:</strong> {{ $encadreur->notes }}</p>
        </div>
    </div>
@endsection