@extends('master')
@section('title')
    Not Found | WMS360
@endsection
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-center">
                    <div class="card p-20 border-danger font-18">
                        <h4 class="text-center">Exception Occured ! Exception Message Is...</h4>
                        @if($message = Session::get('exception'))
                            <strong>{{$message}}</strong>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
