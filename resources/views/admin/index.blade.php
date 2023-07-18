@extends('admin.layouts.app')
@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0 text-white">Dashboard</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow">
            <div class="card-heading p-4">
                <div>
                    <h4 class="text-dark m-1">Total Users</h4>
                    <div class="text-center">
                        <h2 class="text-primary mb-0">{{$totalUsers}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow">
            <div class="card-heading p-4">
                <div>
                    <h4 class="text-dark m-1">Total Teachers</h4>
                    <div class="text-center">
                        <h2 class="text-primary mb-0">{{$totalTeachers}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow">
            <div class="card-heading p-4">
                <div>
                    <h4 class="text-dark m-1">Total Student</h4>
                    <div class="text-center">
                        <h2 class="text-primary mb-0">{{$totalStudents}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow">
            <div class="card-heading p-4">
                <div>
                    <h4 class="text-dark m-1">Total Courses</h4>
                    <div class="text-center">
                        <h2 class="text-primary mb-0">{{count($courses)}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<h4 class="page-title m-0 text-white">Courses vise Total Users</h4>
<hr>
<div class="row">
    @foreach($courses as $course)
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow">
            <div class="card-heading p-4">
                <div>
                    <h4 class="text-dark m-1">{{$course->name}} Users</h4>
                    <div class="text-center">
                        <h2 class="text-primary mb-0">{{count($course->users)}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection