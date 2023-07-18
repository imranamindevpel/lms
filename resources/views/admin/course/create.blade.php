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
                <h4 class="m-t-0 m-b-30">Add User</h4>
                <div class="row">
                    <div class="col-sm-12">
                        <form class="" action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Course Name</label>
                                <input type="text" name="name" class="form-control" required placeholder="Enter Course"/>
                            </div>
                            <div class="form-group">
                                <label>Google Course Folder Id</label>
                                <input type="text" name="folder_id" class="form-control" required placeholder="Enter Course"/>
                            </div>
                            <div class="form-group">
                                <label>Extra Detail</label>
                                <div>
                                    <textarea class="form-control" name="detail" rows="5"></textarea>
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