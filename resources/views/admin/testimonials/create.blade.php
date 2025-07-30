@extends('layouts.admin')

@section('content')
    <h1 class="my-4">Admin: Create Testimonial</h1>
    <form action="{{ route('admin.testimonials.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="client_name" class="form-label">Client Name</label>
            <input type="text" name="client_name" id="client_name" class="form-control">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" id="content" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection