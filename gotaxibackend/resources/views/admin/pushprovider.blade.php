@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Push Notification ')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <a href="{{ url('admin/provider') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i>
                    Back</a>
                <h5 style="margin-bottom: 2em;">Send Push Notification</h5>

                <form class="form-horizontal" action="{{ route('admin.push.provider.post') }}" method="POST"
                    enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}

                    <input type="hidden" name="id" id="id" value="{{ $id }}">
                    @if (session()->has('flash_success'))
                        <div class="alert alert-success">
                            {{ session()->get('flash_success') }}
                        </div>
                    @endif

                    @if (session()->has('flash_error'))
                        <div class="alert alert-danger">
                            {{ session()->get('flash_error') }}
                        </div>
                    @endif

                    <div class="form-group row">
                        <label for="title" class="col-xs-12 col-form-label">{{ translateKeyword('Title') }}</label>
                        <div class="col-xs-12 col-md-6 col-lg-6">
                            <input class="form-control" type="text" value="{{ old('title') }}" name="title" required
                                id="title" placeholder="Title">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="message" class="col-xs-12 col-form-label">{{ translateKeyword('Message') }}</label>
                        <div class="col-xs-12 col-md-6 col-lg-6">
                            <textarea class="pure-input-1-2" style="width: 100%;" name="message" id="message" maxlength="255" rows="5"
                                placeholder="Notification message!" required></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('Send') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
