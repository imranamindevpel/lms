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
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="m-t-0 m-b-30">Edit Lecture </h4>
                <div class="row">
                    <div class="col-sm-12">
                        <form class="" action="{{ route('lectures.update', $lecture->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Course</label>
                                <select class="form-control course-select" id="course" name="course_id" required>
                                    <option value="">Select Course</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}" {{ $course->id == $lecture->course_id ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Video</label>
                                <input type="file" name="video" class="form-control" placeholder="Update Lecture Video (Optional)"/>
                            </div>
                            
                            <div class="form-group">
                                <label>Current Video</label>
                                <video controls width="10%">
                                    <source src="{{ $lecture->video }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="form-group">
                                <label>Extra Detail</label>
                                <div>
                                    <textarea class="form-control" name="detail" value="{{$lecture->detail}}" rows="5">{{$lecture->detail}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>
@endsection