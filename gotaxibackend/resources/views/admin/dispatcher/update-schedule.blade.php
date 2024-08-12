@php use Carbon\Carbon; @endphp
@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Update Dispatcher Schedule')

@section('styles')
    <style type="text/css">
        .container {
            width: 60% !important;
            margin: auto;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper" style="padding-bottom: 0 !important">
        <div id="dispatcher-panel" class="container">
            <form action="{{ route('admin.dispatcher.update-schedule', [ 'id' => $id ]) }}" method="POST">
                {{method_field('PUT')}}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="schedule">{{ translateKeyword('schedule') }}</label>
                    <input type="datetime-local" min="{{ Carbon::now()->format('Y-m-d\TH:i') }}" class="form-control" name="schedule_at" id="schedule_at" required> 
                </div>
                <button class="btn btn-primary" type="submit">{{ translateKeyword('update') }}</button>
            </form>
        </div>
    </div>
@endsection
