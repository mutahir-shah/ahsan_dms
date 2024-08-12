@extends('dispatcher.layout.base')

@section('title', 'Change Password ')

@section('content')
    <style>
        .input-group-addon {
            width: 35px !important;
            border-radius: 5px;
        }
    </style>
    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">

                <h5 style="margin-bottom: 2em;">Change Password</h5>

                <form class="form-horizontal" action="{{route('dispatcher.password.update')}}" method="POST"
                      role="form">
                    {{csrf_field()}}

                    <div class="form-group row">
                        <label for="old_password" class="col-xs-12 col-form-label">Old Password</label>
                        <div class="col-xs-10">
                            <div class="input-group" id="show_hide_old_password">
                                <input class="form-control" type="password" name="old_password" id="old_password"
                                       placeholder="Password">
                                <div class="input-group-addon">
                                    <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-xs-12 col-form-label">Password</label>
                        <div class="col-xs-10">
                            <div class="input-group" id="show_hide_password">
                                <input class="form-control" type="password" name="password" id="password"
                                       placeholder="Password">
                                <div class="input-group-addon">
                                    <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-xs-12 col-form-label">Password
                            Confirmation</label>
                        <div class="col-xs-10">
                            <div class="input-group" id="show_hide_password_confirmation">
                                <input class="form-control" type="password" name="password_confirmation"
                                       id="password_confirmation" placeholder="Password">
                                <div class="input-group-addon">
                                    <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#show_hide_old_password a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_old_password input').attr("type") == "text") {
                    $('#show_hide_old_password input').attr('type', 'password');
                    $('#show_hide_old_password i').addClass("fa-eye-slash");
                    $('#show_hide_old_password i').removeClass("fa-eye");
                } else if ($('#show_hide_old_password input').attr("type") == "password") {
                    $('#show_hide_old_password input').attr('type', 'text');
                    $('#show_hide_old_password i').removeClass("fa-eye-slash");
                    $('#show_hide_old_password i').addClass("fa-eye");
                }
            });

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