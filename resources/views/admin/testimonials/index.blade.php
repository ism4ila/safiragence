@extends('layouts.admin')

@section('content')
    <h1 class="my-4">Admin: Testimonials</h1>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary mb-3">Create Testimonial</a>
    <table class="table">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($testimonials as $testimonial)
                <tr>
                    <td>{{ $testimonial->client_name }}</td>
                    <td>
                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline">
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