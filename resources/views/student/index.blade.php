@extends('admin.layouts.app')
@section('content')
@if($courses)
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0 text-white">Dashboard</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<input type="hidden" id="studentStatus" value="{{$studentStatus}}">
<form action="{{ route('quizzes.clock_in_out') }}" method="POST">
<div class="row">
    @csrf
    <div class="col-sm-6 col-xl-3">
        <button type="submit" class="btn btn-success" id="clock_in" name="clock_in" value="1">Clock In</button>
        <button type="submit" class="btn btn-danger" id="clock_out" name="clock_out" value="1" disabled>Clock Out</button>
    </div>
</div>
</form>
<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="m-b-30 m-t-0">
                    Quizzes
                </h4>
                @foreach ($courses as $course)
                <h4 class="bg-dark text-white p-2">{{ $course->name }} Course</h4>
                @foreach ($course->reports as $report)
                @if($report->user_id === auth()->user()->id )
                <table class="table table-striped table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr>
                            <th>Date Check In/Out</th>
                            <th>Clock In</th>
                            <th>Clock Out</th>
                            <th>Obtained Marks</th>
                            <th>Total Marks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($report->clock_in)
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($report->clock_in)->format('d-m-Y') }} / 
                                    {{ \Carbon\Carbon::parse($report->clock_out)->format('d-m-Y') }}
                                </td>
                                <td>
                                    @if($report->clock_in)
                                    {{ \Carbon\Carbon::parse($report->clock_in)->format('h:i A') }}
                                    @endif
                                </td>
                                <td>
                                    @if($report->clock_out)
                                    {{ \Carbon\Carbon::parse($report->clock_out)->format('h:i A') }}
                                    @endif
                                </td>
                                <td>{{$report->obtained_marks}}</td>
                                <td>{{$report->total_marks}}</td>
                                <td>
                                    <a href="{{ route('logged_in_users.show', $report->id) }}" class="btn btn-success">View</a>
                                </td>
                            </tr>
                            @endif
                    </tbody>
                </table>
                @endif
                @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
<style>
    .btn[disabled] {
  background-color: gray !important;
  border: 1px solid white !important;
  color: white !important;
  font-weight: bold;
}
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var studentStatus = document.getElementById("studentStatus").value;
        var clockInBtn = document.getElementById("clock_in");
        var startBreakBtn = document.getElementById("start_break");
        var endBreakBtn = document.getElementById("end_break");
        var clockOutBtn = document.getElementById("clock_out");
        startBreakBtn.disabled = true;
        endBreakBtn.disabled = true;
        clockOutBtn.disabled = true;
        // alert(studentStatus);
        switch (studentStatus) {
            case "userNoQuiz":
                clockInBtn.disabled = true;
                startBreakBtn.disabled = true;
                endBreakBtn.disabled = true;
                clockOutBtn.disabled = true;
                break;
            case "userClockedIn":
                clockInBtn.disabled = true;
                startBreakBtn.disabled = false;
                endBreakBtn.disabled = true;
                clockOutBtn.disabled = false;
                break;
            case "userStartedBreak":
                clockInBtn.disabled = true;
                startBreakBtn.disabled = true;
                endBreakBtn.disabled = false;
                clockOutBtn.disabled = true;
                break;
            case "userEndedBreak":
                clockInBtn.disabled = true;
                startBreakBtn.disabled = false;
                endBreakBtn.disabled = true;
                clockOutBtn.disabled = false;
                break;
            case "userClockedOut":
                clockInBtn.disabled = true;
                startBreakBtn.disabled = true;
                endBreakBtn.disabled = true;
                clockOutBtn.disabled = true;
                break;
        }
    });
</script>
@endsection