@extends('layouts.app')

@section('content')
    <h1>Settings</h1>
    <ul>
        @foreach ($settings as $setting)
            <li>{{ $setting->setting_key }}: {{ $setting->setting_value }}</li>
        @endforeach
    </ul>
@endsection