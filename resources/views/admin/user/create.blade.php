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
                                    <select class="form-control course-select" id="course" name="course_ids[]" multiple required>
                                        <option value="">Select Course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="quiz-dates">
                                <div class="form-group">
                                    <label>Quiz Date</label>
                                    <input type="date" class="form-control" id="quiz-date" name="quiz_date[]" required placeholder="Enter Quiz Date" />
                                </div>
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