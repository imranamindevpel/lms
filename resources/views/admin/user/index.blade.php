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
                    Users
                    @if(auth()->check() && (auth()->user()->role === 'admin'))
                    <a href="{{ route('users.create') }}" class="btn btn-secondary waves-effect waves-light float-right mb-2">
                        Add User
                    </a>
                    @endif
                </h4>
                <table class="table table-striped table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; width: 100%;">
                @if(@$users)    
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Courses</th>
                            <th>Quiz Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                @foreach ($user->courses as $course)
                                    {{ $course->name }}<br>
                                @endforeach
                            </td>
                            <td>
                                @if($user->reports)
                                @foreach($user->reports as $report)
                                {{ $report->quiz_date }}
                                @endforeach
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    @endif
                    @if(@$courses)
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Courses</th>
                            <th>Student</th>
                            <th>Email</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                        @foreach ($course->users as $i => $user)
                        <tr>
                            @if ($i === 0)
                            <td rowspan="{{ count($course->users) }}">{{ ++$loop->parent->index }}</td>
                            <td rowspan="{{ count($course->users) }}">{{ $course->name }}</td>
                            @endif
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection