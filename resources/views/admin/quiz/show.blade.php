@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            @if(auth()->check() && (auth()->user()->role !== 'student'))
            <a href="{{ url('/logged_in_users') }}" class="btn btn-success">Back</a>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <h4 class="text-center pb-3">Quiz Details</h4>
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <tr>
                                <th>Quiz Date</th>
                                <td>
                                    {{ \Carbon\Carbon::parse($quiz->clock_in)->format('d-m-Y') }} /
                                    {{ \Carbon\Carbon::parse($quiz->clock_out)->format('d-m-Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Clock In Time</th>
                                <td>
                                    @if($quiz->clock_in)
                                        {{ \Carbon\Carbon::parse($quiz->clock_in)->format('h:i A') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Clock Out Time</th>
                                <td>
                                    @if($quiz->clock_out)
                                        {{ \Carbon\Carbon::parse($quiz->clock_out)->format('h:i A') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Total Break Time</th>
                                <td>
                                    @php $totalBreakTime = 0; @endphp
                                    @if(count($quiz->breaks))
                                        @foreach ($quiz->breaks as $break)
                                            @php
                                                $startBreak = \Carbon\Carbon::parse($break->start_break);
                                                $endBreak = \Carbon\Carbon::parse($break->end_break);
                                                $breakDuration = $endBreak->diffInMinutes($startBreak);
                                                $totalBreakTime += $breakDuration;
                                            @endphp
                                            {{ $breakDuration }} Seconds<br>
                                        @endforeach
                                        Total Break Time: {{ floor(($totalBreakTime % (60 * 60)) / 60) }} Minutes
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Total Quiz Time</th>
                                <td>
                                    @if($quiz->clock_out)
                                        @php
                                            $startQuiz = \Carbon\Carbon::parse($quiz->clock_in);
                                            $endQuiz = \Carbon\Carbon::parse($quiz->clock_out);

                                            $quizDurationInSeconds = $endQuiz->diffInSeconds($startQuiz);
                                            $quizDurationInSeconds -= $totalBreakTime;

                                            $days = floor($quizDurationInSeconds / (24 * 60 * 60));
                                            $hours = floor(($quizDurationInSeconds % (24 * 60 * 60)) / (60 * 60));
                                            $minutes = floor(($quizDurationInSeconds % (60 * 60)) / 60);
                                        @endphp
                                        {{ $days }} day, {{ $hours }} hours, {{ $minutes }} minutes
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
