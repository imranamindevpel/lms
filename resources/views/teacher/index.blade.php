@extends('admin.layouts.app')
@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0 text-dark">Dashboard</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow">
            <div class="card-heading bg-success text-white p-4">
                <div>
                    <h4 class="m-1">Total Course</h4>
                    <div class="text-center">
                        <h2 class="mb-0">{{count(@$courses)}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow">
            <div class="card-heading bg-warning text-white p-4">
                <div>
                    <h4 class="m-1">Total Student</h4>
                    <div class="text-center">
                        @php $totalStudentCount = 0; @endphp
                        @foreach($courses as $course)
                        @php
                            $studentCount = 0;
                            foreach ($course->users as $user) {
                                if ($user->role === "student") {
                                    $studentCount++;
                                }
                            }
                        @endphp
                        @php $totalStudentCount += $studentCount; @endphp
                        @endforeach
                        <h2 class="mb-0">{{@$totalStudentCount}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<h4 class="page-title m-0 text-dark">Courses vise Total Users</h4>
<hr>
<div class="row">
    @foreach($courses as $course)
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow">
            <div class="card-heading bg-info text-white p-4">
                <div>
                    <h4 class="m-1">{{@$course->name}} Users</h4>
                    <div class="text-center">
                        @php
                            $studentCount = 0;
                            foreach ($course->users as $user) {
                                if ($user->role === "student") {
                                    $studentCount++;
                                }
                            }
                        @endphp
                        <h2 class="mb-0">{{$studentCount}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection