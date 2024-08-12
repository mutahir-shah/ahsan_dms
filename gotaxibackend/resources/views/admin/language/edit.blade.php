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
                    {{ translateKeyword('back')}}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('edit-language')}}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{ route('admin.language.language-keyword', $language->id) }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-xs-12 col-form-label">{{ translateKeyword('name') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('name') ? old('name') : $language->name }}" name="name" required
                                id="name" placeholder="{{ translateKeyword('name') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-xs-12 col-form-label">{{ translateKeyword('short-name') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('short_name') ? old('short_name') : $language->short_name }}" name="short_name" required
                                id="short_name" placeholder="e:g en">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('update') }}</button>
                            <a href="{{ route('admin.language.index') }}" class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
