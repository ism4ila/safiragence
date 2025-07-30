@extends('layouts.app')

@section('content')
    <h1 class="my-4">Encadreurs</h1>
    <div class="list-group">
        @foreach ($encadreurs as $encadreur)
            <a href="{{ route('encadreurs.show', $encadreur) }}" class="list-group-item list-group-item-action">{{ $encadreur->full_name }}</a>
        @endforeach
    </div>
@endsection