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
    <div class="alert alert-success">{{ session('success') }}</div>
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
                    Logged In Users
                </h4>
                @foreach ($courses as $course)
                    <h4 class="bg-dark text-white p-2">{{ $course->name }}</h4>
                    @foreach ($course->users as $user)
                    @if($user->role === "student")
                    <h5 class="bg-secondary text-white text-center p-1">{{ $user->name }}</h5>
                    <form action="{{ route('ghost_hour') }}" method="PUT">
                        @csrf      
                        <div class="row">
                            <div class="col-md-12 position-relative">     
                                <table class="table table-striped table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date Check In/Out</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Break</th>
                                            <th>Total Quiz Time</th>
                                            <th>+/- Difference</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $hours = 0; $minutes = 0;$totalOverTime = 0; @endphp
                                        @foreach ($user->quizzes as $i => $quiz)
                                        @if($quiz->clock_in)
                                        
                                        @php
                                            $totalQuizMinutes = 0;
                                            $totalBreakMinutes = 0;
                                            $allowedWorkingMinutes = ($user->working_hours/5)*60;
                                        @endphp
                                            <tr>
                                                <td>{{++$i}}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($quiz->clock_in)->format('d-m-Y') }} / 
                                                    {{ \Carbon\Carbon::parse($quiz->clock_out)->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    @if($quiz->clock_in)
                                                    {{ \Carbon\Carbon::parse($quiz->clock_in)->format('h:i A') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($quiz->clock_out)
                                                    {{ \Carbon\Carbon::parse($quiz->clock_out)->format('h:i A') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(count($quiz->breaks))
                                                    @foreach ($quiz->breaks as $break)
                                                        @php
                                                            $startBreak = \Carbon\Carbon::parse($break->start_break);
                                                            $endBreak = \Carbon\Carbon::parse($break->end_break);
                                                            $minutes = $endBreak->diffInMinutes($startBreak) % 60;
                                                            
                                                            $singleBreakHour = intdiv($minutes, 60);
                                                            $singleBreakMinutes = $minutes % 60;

                                                            $totalBreakMinutes += $minutes;
                                                            $totalHours = intdiv($totalBreakMinutes, 60);
                                                            $totalMinutes = $totalBreakMinutes % 60;
                                                        @endphp
                                                        @if ($singleBreakHour){{ $singleBreakHour }} hour @endif
                                                        @if ($singleBreakMinutes){{ $singleBreakMinutes }} minutes @endif<br>
                                                    @endforeach
                                                    Total Break Time: 
                                                    @if ($totalHours){{ $totalHours }} hour @endif
                                                    @if ($totalMinutes){{ $totalMinutes }} minutes @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($quiz->clock_out)
                                                    @php
                                                        $startQuiz = \Carbon\Carbon::parse($quiz->clock_in);
                                                        $endQuiz = \Carbon\Carbon::parse($quiz->clock_out);
                                                        $minutesSpend = $endQuiz->diffInMinutes($startQuiz);
                                                        $totalWorkedMinutes = $minutesSpend - $totalBreakMinutes;
                                                        $hours = intdiv($totalWorkedMinutes, 60);
                                                        $minutes = $totalWorkedMinutes % 60;
                                                    @endphp
                                                    @if ($hours){{ $hours }} hour @endif
                                                    @if ($minutes){{ $minutes }} minutes @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $overTime = $totalWorkedMinutes - $allowedWorkingMinutes;
                                                        $hours = intdiv($overTime, 60);
                                                        $minutes = $overTime % 60;
                                                    @endphp
                                                    @if($quiz->ghost_quiz  == $quiz->created_at)
                                                        @if($quiz->clock_out  > $quiz->clock_in)
                                                            <strong class="text-success">Ghost Quiz</strong>
                                                        @else
                                                            <strong class="text-danger">Ghost Quiz</strong>
                                                        @endif
                                                    @else
                                                        @if ($hours){{ $hours }} hour @endif
                                                        @if ($minutes){{ $minutes }} minutes @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('logged_in_users.show', $quiz->id) }}" class="btn btn-success">View</a>
                                                    @if($quiz->status != 1)
                                                    <form action="{{ route('logged_in_users.update', $quiz->id) }}" method="POST" style="display: inline-block">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-primary">Approve</button>
                                                    </form>
                                                    @endif
                                                    <form action="{{ route('logged_in_users.destroy', $quiz->id) }}" method="POST" style="display: inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Reject</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @php
                                            if($quiz->ghost_quiz === NULL){
                                                $totalOverTime = $totalOverTime +$overTime;
                                            }
                                                $hours = intdiv($totalOverTime, 60);
                                                $minutes = $totalOverTime % 60;
                                            @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 position-absolute">  
                                <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}" readonly>   
                                <input type="hidden" id="over_time" name="over_time" value="{{$totalOverTime}}" readonly>
                                @if($totalOverTime != 0)
                                <button type="submit" class="btn btn-dark text-right">
                                    Flatten Difference(
                                    @if ($hours){{ $hours }} hour @endif
                                    @if ($minutes){{ $minutes }} minutes @endif
                                    @if (!$hours && !$minutes) 0 minutes @endif)
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>
                    @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#courseDropdown').change(function () {
            var courseId = $(this).val();

            if (courseId !== '') {
                $.ajax({
                    url: 'quizzes/get_course_users/' + courseId,
                    type: 'GET',
                    success: function (response) {
                        var userDropdown = $('#userDropdown');
                        userDropdown.empty();

                        if (response.length > 0) {
                            userDropdown.append('<option value="">Select User</option>');

                            $.each(response, function (index, user) {
                                userDropdown.append('<option value="' + user.id + '">' + user.name + '</option>');
                            });

                            userDropdown.removeClass('hidden');
                        } else {
                            userDropdown.addClass('hidden');
                        }
                    }
                });
            } else {
                $('#userDropdown').addClass('hidden');
            }
        });
    });
</script>
@endsection