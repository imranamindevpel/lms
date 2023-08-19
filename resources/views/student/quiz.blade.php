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
                <form action="{{ route('quizzes.submit_quiz') }}" method="POST">
                    @csrf
                    <input type="hidden" name="report_id" value="{{$id}}">
                    @foreach($questions as $key => $question)
                        <div class="col-md-12">
                            <h5>{{$key+1}}: {{ $question->question }}</h5>
                        </div>
                        <div class="col-md-12 ml-4">
                            <input class="form-check-input" type="radio" name="answer[{{ $question->id }}]" id="option{{ $question->id }}_a" value="a">
                            <label class="form-check-label" for="option{{ $question->id }}_a">
                                {{ $question->option_a }}
                            </label>
                        </div>
                        <div class="col-md-12 ml-4">
                            <input class="form-check-input" type="radio" name="answer[{{ $question->id }}]" id="option{{ $question->id }}_b" value="b">
                            <label class="form-check-label" for="option{{ $question->id }}_b">
                                {{ $question->option_b }}
                            </label>
                        </div>
                        <div class="col-md-12 ml-4">
                            <input class="form-check-input" type="radio" name="answer[{{ $question->id }}]" id="option{{ $question->id }}_c" value="c">
                            <label class="form-check-label" for="option{{ $question->id }}_c">
                                {{ $question->option_c }}
                            </label>
                        </div>
                        <div class="col-md-12 ml-4">
                            <input class="form-check-input" type="radio" name="answer[{{ $question->id }}]" id="option{{ $question->id }}_d" value="d">
                            <label class="form-check-label" for="option{{ $question->id }}_d">
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