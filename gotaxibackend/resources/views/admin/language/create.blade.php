@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Add Language ')

@section('content')
    <style>
        .input-group-addon {
            width: 35px !important;
            border-radius: 5px;
        }
    </style>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">

                <a href="{{ route('admin.language.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i>
                    {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('add-language') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{ route('admin.language.language-keyword') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-xs-12 col-form-label">{{ translateKeyword('name')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('name') }}" name="name" required
                                id="name" placeholder="{{ translateKeyword('name')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-xs-12 col-form-label">{{ translateKeyword('short-name') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('short_name') }}" name="short_name" required
                                id="short_name" placeholder="e:g en">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('add-language') }}</button>
                            <a href="{{ route('admin.language.index') }}" class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="box box-block bg-white">
                <h5 style="margin-bottom: 2em;">{{ translateKeyword('import-language') }}</h5>
                <form class="form-horizontal" action="{{ route('admin.language.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="file" name="import_file" required
                                id="import_file">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('import') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
