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
                <h4 class="m-t-0 m-b-30">Edit User</h4>
                <div class="row">
                    <div class="col-sm-12">
                        <form class="" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required placeholder="Enter Name" value="{{ $user->name }}"/>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" required placeholder="Enter Email" value="{{ $user->email }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Enter Password" value="{{ $user->password }}"/>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="Re-Enter Password" value="{{ $user->password }}"/>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" id="role" name="role" required onchange="toggleCourseDiv()">
                                    <option value="">Select Role</option>
                                    <option value="teacher" {{ $user->role == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                    <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                                </select>
                            </div>
                            <div id="course-div" class="role-div">
                                <div class="form-group">
                                    <label>Course</label>
                                    <select class="form-control course-select" id="course" name="course_ids[]" multiple required>
                                        <option value="">Select Course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}" {{ $user->courses->contains('id', $course->id) ? 'selected' : '' }}>
                                                {{ $course->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="quiz-dates">
                                @foreach ($user->reports as $report)
                                    <div class="form-group">
                                        <label>Quiz Date for {{ $report->course->name }}</label>
                                        <input type="date" class="form-control" name="quiz_date[{{ $report->course_id }}]" value="{{ $report->quiz_date }}" required />
                                    </div>
                                @endforeach
                            </div>                            
                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        Update
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Event handler for course select changes
        $('.course-select').change(function () {
            // Clear existing quiz date inputs
            $('.quiz-dates').empty();
            
            // Get the selected courses
            var selectedCourses = $('.course-select option:selected');
            
            // Generate quiz date inputs for each selected course
            selectedCourses.each(function (index, course) {
                var courseId = $(course).val();
                var courseName = $(course).text();
                
                // Generate quiz date input HTML for the current course
                var quizDateInput = '<div class="form-group">' +
                    '<label>Quiz Date for ' + courseName + '</label>' +
                    '<input type="date" class="form-control" name="quiz_date[' + courseId + ']" required />' +
                    '</div>';
                
                // Append the quiz date input to the container
                $('.quiz-dates').append(quizDateInput);
            });
        });
    });
</script>
@endsection