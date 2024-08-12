@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Update Role ')

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
                <a href="{{ route('admin.role.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back')}}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('Update Role')}}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('admin.role.update', $role->id )}}" method="POST">
                   @csrf 
                   @method('_PUT')
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group row">
                        <label for="name" class="col-xs-2 col-form-label">{{ translateKeyword('name')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $role->name }}" name="name"
                                   required id="name" placeholder="{{ translateKeyword('name')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('Update Role')}}</button>
                            <a href="{{route('admin.role.index')}}" class="btn btn-default">{{ translateKeyword('cancel')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

