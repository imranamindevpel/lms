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
                    Quizzes
                    <button type="button" class="btn btn-secondary waves-effect waves-light float-right" data-toggle="modal" data-target="#addQuizModal">
                        Add New Quiz
                    </button>
                    <!-- Button to trigger the modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                        Upload CSV
                    </button>
                    <a  class="btn btn-secondary" href="{{ asset('quizzes.csv') }}" download>Download Sample Csv File</a>
                </h4>     
                <!-- Modal -->
                <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadModalLabel">Upload CSV</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('quizzes.handleUpload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="finish_time">Select Course</label>
                                        <select class="form-control courseDropdown" name="course_id" required>
                                            <option value="">Select Course</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="csv_file">CSV File</label>
                                        <input type="file" class="form-control-file" id="csv_file" name="csv_file" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="uploadBtn">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Add Quiz Modal -->
                <div class="modal fade" id="addQuizModal" tabindex="-1" role="dialog" aria-labelledby="addQuizModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addQuizModalLabel">Add New Quiz</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('quizzes.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="finish_time">Select Course</label>
                                        <select class="form-control courseDropdown" name="course_id" required>
                                            <option value="">Select Course</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="finish_time">Select User</label>
                                        <select id="userDropdown" class="form-control hidden" name="user_id" required>
                                            <!-- Dynamically Populated Users -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="quiz_date">Quiz Date</label>
                                        <input type="date" class="form-control" id="quiz_date" name="quiz_date" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="start_time">Quiz Start Time</label>
                                        <input type="time" class="form-control" id="start_time" name="start_time" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="finish_time">Quiz Finish Time</label>
                                        <input type="time" class="form-control" id="finish_time" name="finish_time" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="break_allocation">Break Allocation</label>
                                        <input type="number" class="form-control" min="0" id="break_allocation" name="break_allocation" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Add Quiz</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($courses as $course)
                    <h3 class="text-center">{{ $course->name }}</h3>
                    <table class="table table-striped table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Quiz Date</th>
                                <th>Start Time</th>
                                <th>Finish Time</th>
                                <th>Break Allocation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($course->users as $user)
                            @foreach ($user->quizzes as $i => $quiz)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $quiz->quiz_date }}</td>
                                    <td>{{ $quiz->start_time }}</td>
                                    <td>{{ $quiz->finish_time }}</td>
                                    <td>{{ $quiz->break_allocation }}</td>
                                    <td>
                                        <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection