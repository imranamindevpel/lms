@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8"></div>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="m-b-30 m-t-0">
                    Courses
                    @if(auth()->check() && (auth()->user()->role === 'admin'))
                    <a href="{{ route('courses.create') }}" class="btn btn-secondary waves-effect waves-light float-right mb-2">
                        Add Course
                    </a>
                    @endif
                </h4>
                <table class="table table-striped table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; width: 100%;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Created At</th>
                        @if(auth()->check() && (auth()->user()->role === 'admin'))
                        <th>Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->created_at }}</td>
                                @if(auth()->check() && (auth()->user()->role === 'admin'))
                                <td>
                                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course?')"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection