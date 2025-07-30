@extends('layouts.admin')

@section('content')
    <h1 class="my-4">Admin: Edit Setting</h1>
    <form action="{{ route('admin.settings.update', $setting) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="setting_key" class="form-label">Key</label>
            <input type="text" name="setting_key" id="setting_key" class="form-control" value="{{ $setting->setting_key }}">
        </div>
        <div class="mb-3">
            <label for="setting_value" class="form-label">Value</label>
            <textarea name="setting_value" id="setting_value" class="form-control">{{ $setting->setting_value }}</textarea>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ $setting->description }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection