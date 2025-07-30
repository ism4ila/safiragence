@extends('layouts.admin')

@section('content')
    <h1 class="my-4">Admin: Edit City</h1>
    <form action="{{ route('admin.cities.update', $city) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $city->name }}">
        </div>
        <div class="mb-3">
            <label for="region" class="form-label">Region</label>
            <input type="text" name="region" id="region" class="form-control" value="{{ $city->region }}">
        </div>
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" name="country" id="country" class="form-control" value="{{ $city->country }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection