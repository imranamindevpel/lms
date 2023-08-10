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
                </h4> 
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
                                        <label for="question">Qusetion</label>
                                        <input type="question" class="form-control" id="question" name="question" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="option_a">Option A</label>
                                        <input type="text" class="form-control" id="option_a" name="option_a" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="option_b">Option B</label>
                                        <input type="text" class="form-control" id="option_b" name="option_b" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="option_c">Option C</label>
                                        <input type="text" class="form-control" id="option_c" name="option_c" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="option_d">Option D</label>
                                        <input type="text" class="form-control" id="option_d" name="option_d" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="correct_option">Correct Option</label>
                                        <input type="text" class="form-control" id="correct_option" name="correct_option" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="total_marks">Total Marks</label>
                                        <input type="number" class="form-control" min="0" id="total_marks" name="total_marks" required>
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
                                <th>Question</th>
                                <th>Option A</th>
                                <th>Option B</th>
                                <th>Option C</th>
                                <th>Option D</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course->quizzes as $i => $quiz)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{ $quiz->question }}</td>
                                    <td>{{ $quiz->option_a }}</td>
                                    <td>{{ $quiz->option_b }}</td>
                                    <td>{{ $quiz->option_c }}</td>
                                    <td>{{ $quiz->option_d }}</td>
                                    <td>{{ $quiz->total_marks }}</td>
                                    <td>
                                        <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-primary m-1 p-2"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger m-1 p-2" onclick="return confirm('Are you sure you want to delete this user?')"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection