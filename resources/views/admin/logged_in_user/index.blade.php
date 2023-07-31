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
                    {{-- <form action="{{ route('ghost_hour') }}" method="PUT">
                        @csrf       --}}
                        <div class="row">
                            <div class="col-md-12 position-relative">     
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
                                        @foreach ($user->reports as $report)
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
                                                        <a href="#" class="btn btn-danger">
                                                            <strong>Not Attended</strong>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {{-- </form> --}}
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