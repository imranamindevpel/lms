@extends('admin.layouts.app')
@section('content')
@if($questions)
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0 text-white">Quiz</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center">Multiple Choice Questions</h3>
                <form>
                    @foreach($questions as $key => $question)
                        <div class="col-md-12">
                            <h5>{{$key+1}}: {{ $question->question }}</h5>
                        </div>
                        <div class="col-md-12 ml-4">
                            <input class="form-check-input" type="radio" name="answer" id="option{{ $question->option_a }}" value="{{ $question->option_a }}">
                            <label class="form-check-label" for="option{{ $question->option_a }}">
                                {{ $question->option_a }}
                            </label>
                        </div>
                        <div class="col-md-12 ml-4">
                            <input class="form-check-input" type="radio" name="answer" id="option{{ $question->option_b }}" value="{{ $question->option_b }}">
                            <label class="form-check-label" for="option{{ $question->option_b }}">
                                {{ $question->option_b }}
                            </label>
                        </div>
                        <div class="col-md-12 ml-4">
                            <input class="form-check-input" type="radio" name="answer" id="option{{ $question->option_c }}" value="{{ $question->option_c }}">
                            <label class="form-check-label" for="option{{ $question->option_c }}">
                                {{ $question->option_c }}
                            </label>
                        </div>
                        <div class="col-md-12 ml-4">
                            <input class="form-check-input" type="radio" name="answer" id="option{{ $question->option_d }}" value="{{ $question->option_d }}">
                            <label class="form-check-label" for="option{{ $question->option_d }}">
                                {{ $question->option_d }}
                            </label>
                        </div>
                        <hr>
                    @endforeach
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection