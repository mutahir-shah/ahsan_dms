@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Update Account Manager ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <a href="{{ route('admin.account-manager.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('update_account_manager') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('admin.account-manager.update', $account->id )}}"
                      method="POST" enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PATCH">

                    <div class="form-group row">
                        <label for="name" class="col-xs-2 col-form-label">{{ translateKeyword('full_name') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $account->name }}" name="name" required
                                   id="name" placeholder="{{ translateKeyword('full_name') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-xs-2 col-form-label">{{ translateKeyword('email') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $account->email }}" readonly="true"
                                   name="email" required id="email" placeholder="{{ translateKeyword('email') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mobile" class="col-xs-2 col-form-label">{{ translateKeyword('mobile')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $account->mobile }}" name="mobile"
                                   required id="mobile" minlength="10" maxlength="15" placeholder="{{ translateKeyword('mobile')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('update_account_manager') }}</button>
                            <a href="{{route('admin.account-manager.index')}}" class="btn btn-default">{{ translateKeyword('cancel')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
