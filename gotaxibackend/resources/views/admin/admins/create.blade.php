@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Add User ')

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

                <a href="{{ route('admin.admin.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back')}}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('Add_User') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('admin.admin.store')}}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label for="first_name" class="col-xs-12 col-form-label">{{translateKeyword('name')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('name') }}" name="name"
                                   required id="name" placeholder="{{translateKeyword('name')}}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="email" class="col-xs-12 col-form-label">{{ translateKeyword('email') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="email" required name="email" value="{{old('email')}}"
                                   id="email" placeholder="{{ translateKeyword('email') }}">
                        </div>
                    </div>
                  
                    <div class="form-group row">
                        <label for="password" class="col-xs-12 col-form-label">{{ translateKeyword('password') }}</label>
                        <div class="col-xs-10">
                            <div class="input-group" id="show_hide_password">
                                <input class="form-control" type="password" name="password" id="password"
                                       placeholder="{{ translateKeyword('password') }}">
                                <div class="input-group-addon">
                                    <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-xs-12 col-form-label">{{ translateKeyword('password_confirmation')}}
                            </label>
                        <div class="col-xs-10">
                            <div class="input-group" id="show_hide_password_confirmation">
                                <input class="form-control" type="password" name="password_confirmation"
                                       id="password_confirmation" placeholder="{{ translateKeyword('password') }}">
                                <div class="input-group-addon">
                                    <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="picture" class="col-xs-12 col-form-label">{{ translateKeyword('picture')}}</label>
                        <div class="col-xs-10">
                            <input type="file" accept="image/*" name="picture" class="dropify form-control-file"
                                   id="picture" aria-describedby="fileHelp">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="first_name" class="col-xs-12 col-form-label">{{ translateKeyword('role-new') }}</label>
                        <div class="col-xs-10">
                           <select name="role_id" id="role_id" class="form-control">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                           </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('Add_User') }}</button>
                            <a href="{{route('admin.admin.index')}}" class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            $("#show_hide_password a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });

            $("#show_hide_password_confirmation a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_password_confirmation input').attr("type") == "text") {
                    $('#show_hide_password_confirmation input').attr('type', 'password');
                    $('#show_hide_password_confirmation i').addClass("fa-eye-slash");
                    $('#show_hide_password_confirmation i').removeClass("fa-eye");
                } else if ($('#show_hide_password_confirmation input').attr("type") == "password") {
                    $('#show_hide_password_confirmation input').attr('type', 'text');
                    $('#show_hide_password_confirmation i').removeClass("fa-eye-slash");
                    $('#show_hide_password_confirmation i').addClass("fa-eye");
                }
            });
        });
    </script>
@endsection
