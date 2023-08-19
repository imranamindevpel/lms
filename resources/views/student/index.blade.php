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
{{-- <form action="{{ route('quizzes.clock_in_out') }}" method="POST">
<div class="row">
    @csrf
    <div class="col-sm-6 col-xl-3">
        <button type="submit" class="btn btn-success" id="clock_in" name="clock_in" value="1">Clock In</button>
        <button type="submit" class="btn btn-danger" id="clock_out" name="clock_out" value="1" disabled>Clock Out</button>
    </div>
</div>
</form> --}}
<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="m-b-30 m-t-0">
                    Quizzes
                </h4>
                @foreach ($courses as $course)
                <h4 class="bg-dark text-white p-2">{{ $course->name }} Course</h4>
                <table class="table table-striped table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr>
                            <th>Date Check In/Out</th>
                            <th>Clock In</th>
                            <th>Clock Out</th>
                            <th>Obtained Marks</th>
                            <th>Total Marks</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->reports as $report)
                        @if($report->user_id === auth()->user()->id )
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($report->quiz_date)->format('d-m-Y') }}
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
                                    @if ($report->status === 0)
                                        <span class="text-danger"><strong>Fail</strong></span>
                                    @elseif ($report->status === 1)
                                        <span class="text-success"><strong>Pass</strong></span>
                                    @else
                                        @if(\Carbon\Carbon::parse($report->quiz_date)->format('d-m-Y') <= \Carbon\Carbon::now()->format('d-m-Y'))
                                            <a href="{{ route('quizzes.start_quiz', $report->id) }}" class="btn btn-secondary">
                                                <strong>Start Quiz</strong>
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-danger">
                                                <strong>Quiz Date ({{ \Carbon\Carbon::parse($report->quiz_date)->format('d-m-Y') }})</strong>
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
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
@endsection