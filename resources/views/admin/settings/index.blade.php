@extends('layouts.admin')

@section('content')
    <h1 class="my-4">Admin: Site Settings</h1>
    <a href="{{ route('admin.settings.create') }}" class="btn btn-primary mb-3">Create Setting</a>
    <table class="table">
        <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($settings as $setting)
                <tr>
                    <td>{{ $setting->setting_key }}</td>
                    <td>{{ $setting->setting_value }}</td>
                    <td>
                        <a href="{{ route('admin.settings.edit', $setting) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.settings.destroy', $setting) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection