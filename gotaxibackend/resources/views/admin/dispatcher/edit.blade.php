@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Update Dispatcher ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <a href="{{ route('admin.dispatch-manager.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('update_dispatcher') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('admin.dispatch-manager.update', $dispatcher->id )}}"
                      method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PATCH">

                    <div class="form-group row">
                        <label for="name" class="col-xs-2 col-form-label">{{ translateKeyword('full_name') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $dispatcher->name }}" name="name" required
                                   id="name" placeholder="{{ translateKeyword('full_name') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-xs-2 col-form-label">{{ translateKeyword('email') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $dispatcher->email }}" readonly="true"
                                   name="email" required id="email" placeholder="{{ translateKeyword('email') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mobile" class="col-xs-2 col-form-label">{{ translateKeyword('mobile') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $dispatcher->mobile }}" name="mobile"
                                   required id="mobile" minlength="10" maxlength="15" placeholder="{{ translateKeyword('mobile') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('update_dispatcher') }}</button>
                            <a href="{{route('admin.dispatch-manager.index')}}" class="btn btn-default">{{ translateKeyword('update_dispatcher') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
