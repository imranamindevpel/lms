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
                                    <option value="{{ $course->id }}" {{ ($quiz->user->courses[0]->id == $course->id) ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="finish_time">Select User</label>
                                <select id="userDropdown" class="form-control hidden" name="user_id" value="{{$quiz->user_id}}" required>
                                    @foreach ($selected_course_users as $user)
                                    <option value="{{ $user->id }}" {{ ($user->id == $quiz->user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                    <!-- Dynamically Populated Users -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quiz_date">Quiz Date</label>
                                <input type="date" class="form-control" id="quiz_date" name="quiz_date" value="{{$quiz->quiz_date}}" required>
                            </div>

                            <div class="form-group">
                                <label for="start_time">Quiz Start Time</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" value="{{$quiz->start_time}}" required>
                            </div>

                            <div class="form-group">
                                <label for="finish_time">Quiz Finish Time</label>
                                <input type="time" class="form-control" id="finish_time" name="finish_time" value="{{$quiz->finish_time}}" required>
                            </div>

                            <div class="form-group">
                                <label for="break_allocation">Break Allocation</label>
                                <input type="number" class="form-control" min="0" id="break_allocation" name="break_allocation" value="{{$quiz->break_allocation}}" required>
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
