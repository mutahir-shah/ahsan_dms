@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Update Profile ')



@section('content')

    <div class="content-wrapper">

        <div class="container-fluid">

            <div class="box box-block bg-white border-radius-10">


                <h5 style="margin-bottom: 2em;">{{translateKeyword('update_profile') }}</h5>
                @include('common.notify')


                <form class="form-horizontal" action="{{route('admin.profile.update')}}" method="POST"
                      enctype="multipart/form-data" role="form">

                    {{csrf_field()}}


                    <div class="form-group row">

                        <label for="name" class="col-xs-2 col-form-label">{{ translateKeyword('name') }}</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="text" value="{{ Auth::guard('admin')->user()->name }}"
                                   name="name" required id="name" placeholder="{{ translateKeyword('name') }}">

                        </div>

                    </div>


                    <div class="form-group row">

                        <label for="email" class="col-xs-2 col-form-label">{{ translateKeyword('email') }}</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="email" required name="email"
                                   value="{{ isset(Auth::guard('admin')->user()->email) ? Auth::guard('admin')->user()->email : '' }}"
                                   id="email" placeholder="{{ translateKeyword('email') }}">

                        </div>

                    </div>


                    <div class="form-group row">

                        <label for="picture" class="col-xs-2 col-form-label">{{ translateKeyword('picture') }}</label>

                        <div class="col-xs-10">


                            <input type="file" accept="image/*" name="picture" class=" dropify form-control-file"
                                   aria-describedby="fileHelp">

                        </div>

                    </div>


                    <div class="form-group row">

                        <label for="zipcode" class="col-xs-2 col-form-label"></label>

                        <div class="col-xs-10">

                            <button type="submit" class="btn btn-primary">{{ translateKeyword('update_profile') }}</button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

