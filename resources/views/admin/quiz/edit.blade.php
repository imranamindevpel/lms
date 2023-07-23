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
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="m-t-0 m-b-30">Edit Quiz</h4>
                <div class="row">
                    <div class="col-sm-12">
                        <form action="{{ route('quizzes.update', $quiz->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="finish_time">Select Course</label>
                                <select class="form-control courseDropdown" name="course_id" required>
                                    <option value="">Select Course</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" {{ ($quiz->course->id == $course->id) ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="question">Qusetion</label>
                                <input type="question" class="form-control" id="question" name="question" value="{{$quiz->question}}" required>
                            </div>

                            <div class="form-group">
                                <label for="option_a">Option A</label>
                                <input type="text" class="form-control" id="option_a" name="option_a" value="{{$quiz->option_a}}" required>
                            </div>
                            <div class="form-group">
                                <label for="option_b">Option B</label>
                                <input type="text" class="form-control" id="option_b" name="option_b" value="{{$quiz->option_b}}" required>
                            </div>
                            <div class="form-group">
                                <label for="option_c">Option C</label>
                                <input type="text" class="form-control" id="option_c" name="option_c" value="{{$quiz->option_c}}" required>
                            </div>
                            <div class="form-group">
                                <label for="option_d">Option D</label>
                                <input type="text" class="form-control" id="option_d" name="option_d" value="{{$quiz->option_d}}" required>
                            </div>
                            <div class="form-group">
                                <label for="correct_option">Correct Option</label>
                                <input type="text" class="form-control" id="correct_option" name="correct_option" value="{{$quiz->correct_option}}" required>
                            </div>
                            <div class="form-group">
                                <label for="total_marks">Total Marks</label>
                                <input type="number" class="form-control" min="0" id="total_marks" name="total_marks" value="{{$quiz->total_marks}}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Quiz</button>
                        </form>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>
@endsection
