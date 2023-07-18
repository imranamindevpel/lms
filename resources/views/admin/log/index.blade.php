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
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="m-b-30 m-t-0">
                    Logs
                </h4>
                <table class="table table-striped table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Event</th>
                            <th>Who</th>
                            <th>When</th>
                            <th>Where</th>
                            <th>How</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($logs as $i => $log)
                    <tr>
                        <td>{{++$i}}</td>
                        <td>{{$log->event}}</td>
                        <td>{{$log->who}}</td>
                        <td>
                            @php
                                $dateTime = $log->when;
                                $carbonDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dateTime);
                                $formattedDateTime = $carbonDateTime->format('Y-m-d h:i:s A');
                            @endphp
                            {{ $formattedDateTime }}
                        </td>
                        <td>{{$log->where}}</td>
                        <td>{{$log->how}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection