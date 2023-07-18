@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                </div>
            </div>
        </div>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="m-t-0 m-b-30">Add User</h4>
                <div class="row">
                    <div class="col-sm-12">
                        <form class="" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required placeholder="Enter Name"/>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <div class="input-group">
                                    <input id="email" type="text" class="form-control" name="email" required placeholder="Enter Email"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">@gmail.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required placeholder="Enter Password"/>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" required placeholder="Re-Enter Password"/>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="student">Student</option>
                                </select>
                            </div>
                            <div id="course-div" class="role-div">
                                <div class="form-group">
                                    <label>Course</label>
                                    <select class="form-control" id="course" name="course_ids[]" multiple required>
                                        <option value="">Select Course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{--<div id="teacher-div" class="role-div">
                                <div class="form-group">
                                    <label>Teacher Course(s)</label>
                                    <select class="form-control" id="teacher-role" name="course_ids[]" multiple>
                                        <option value="">Select Course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="student-div" class="role-div">
                                <div class="form-group">
                                    <label>Student Course</label>
                                    <select class="form-control" id="student-role" name="course_ids[]">
                                        <option value="">Select Course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>--}}
                            <div class="form-group">
                                <label>Contract Hours per Week</label>
                                <input type="number" class="form-control" min="1" name="working_hours" required placeholder="Enter Contract Hours per Week"/>
                            </div>
                            <div class="form-group">
                                <label>Break Hours per Day</label>
                                <input type="number" class="form-control" min="1" name="break_minutes" required placeholder="Enter Break Hours per Day"/>
                            </div>
                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>
@endsection