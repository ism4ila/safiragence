@extends('layouts.admin')

@section('content')
    <h1 class="my-4">Admin: Cities</h1>
    <a href="{{ route('admin.cities.create') }}" class="btn btn-primary mb-3">Create City</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cities as $city)
                <tr>
                    <td>{{ $city->name }}</td>
                    <td>
                        <a href="{{ route('admin.cities.edit', $city) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.cities.destroy', $city) }}" method="POST" class="d-inline">
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