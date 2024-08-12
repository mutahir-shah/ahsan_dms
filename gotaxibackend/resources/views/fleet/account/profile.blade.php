@extends('fleet.layout.basecode')
@extends('admin.layout.base2')

@section('title', 'Update Profile ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('update_profile')}}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('fleet.profile.update')}}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{csrf_field()}}

                    <div class="form-group row">
                        <label for="name" class="col-xs-2 col-form-label">{{ translateKeyword('name')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Auth::guard('fleet')->user()->name }}"
                                   name="name" required id="name" placeholder="{{ translateKeyword('name')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-xs-2 col-form-label">{{ translateKeyword('email')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="email" required name="email"
                                   value="{{ isset(Auth::guard('fleet')->user()->email) ? Auth::guard('fleet')->user()->email : '' }}"
                                   id="email" placeholder="{{ translateKeyword('email')}}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="company" class="col-xs-2 col-form-label">{{ translateKeyword('Company')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" required name="company"
                                   value="{{ isset(Auth::guard('fleet')->user()->company) ? Auth::guard('fleet')->user()->company : '' }}"
                                   id="company" placeholder="{{ translateKeyword('Company')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mobile" class="col-xs-2 col-form-label">{{ translateKeyword('mobile')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" required name="mobile"
                                   value="{{ isset(Auth::guard('fleet')->user()->mobile) ? Auth::guard('fleet')->user()->mobile : '' }}"
                                   id="mobile" minlength="10" maxlength="15" placeholder="{{ translateKeyword('mobile')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="logo" class="col-xs-2 col-form-label">{{ translateKeyword('Logo')}}</label>
                        <div class="col-xs-10">
                            @if(isset(Auth::guard('fleet')->user()->logo))
                                <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                     src="{{img('storage/'.Auth::guard('fleet')->user()->logo)}}">
                            @endif
                            <input type="file" accept="image/*" name="logo" class=" dropify form-control-file"
                                   aria-describedby="fileHelp">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('update_profile')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
