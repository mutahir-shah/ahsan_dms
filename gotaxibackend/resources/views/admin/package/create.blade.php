@extends('admin.layout.base')


@section('title', 'Add Service Package ')



@section('content')

    <div class="content-area py-1">

        <div class="container-fluid">

            <div class="box box-block bg-white">

                <a href="{{ route('admin.package.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back')}}</a>


                <h5 style="margin-bottom: 2em;">{{ translateKeyword('Add Service Package')}}</h5>
                @include('common.notify')


                <form class="form-horizontal" action="{{route('admin.package.store')}}" method="POST"
                      enctype="multipart/form-data" role="form">

                    {{ csrf_field() }}

                    <div class="form-group row">

                        <label for="name" class="col-xs-12 col-form-label">{{ translateKeyword('package-name')}}</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="text" value="{{ old('name') }}" name="name" required
                                   id="name" placeholder="{{ translateKeyword('package-name')}}">

                        </div>

                    </div>


                    <div class="form-group row">

                        <label for="base_time" class="col-xs-12 col-form-label">{{ translateKeyword('Base(Minimum) Time (In Hour)')}}</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="number" value="{{ old('base_time') }}" name="base_time"
                                   required id="base_time" placeholder="0">

                        </div>

                    </div>


                    <div class="form-group row">

                        <label for="base_distance" class="col-xs-12 col-form-label">{{ translateKeyword('Base(Minimum) Distance')}} (In
                            @if (Setting::get('distance_system') === 'metric')
                                KM
                            @else
                                Miles
                            @endif )</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="number" value="{{ old('base_distance') }}"
                                   name="base_distance" required id="base_distance" placeholder="0">

                        </div>

                    </div>


                    <div class="form-group row">

                        <label for="base_price" class="col-xs-12 col-form-label">{{ translateKeyword('Base(Fixed) Price')}} ({{ currency() }}
                            )</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="number" value="{{ old('base_price') }}" name="base_price"
                                   required id="base_price" placeholder="Base Price">

                        </div>

                    </div>


                    <div class="form-group row">

                        <label for="after_time_price" class="col-xs-12 col-form-label">{{ translateKeyword('Per Hour Price (After Minimum Time Complete)')}}</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="number" value="{{ old('after_time_price') }}"
                                   name="after_time_price" required id="after_time_price" placeholder="0">

                        </div>

                    </div>


                    <div class="form-group row">

                        <label for="after_distance_price" class="col-xs-12 col-form-label">{{ translateKeyword('Per KM Price (After Minimum Distance Complete)')}}</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="number" value="{{ old('after_distance_price') }}"
                                   name="after_distance_price" required id="after_distance_price" placeholder="0">

                        </div>

                    </div>


                    <div class="form-group row">

                        <div class="col-xs-10">

                            <div class="row">

                                <div class="col-xs-12 col-sm-6 col-md-3">

                                    <a href="{{ route('admin.package.index') }}"
                                       class="btn btn-danger btn-block">{{ translateKeyword('cancel')}}</a>

                                </div>

                                <div class="col-xs-12 col-sm-6 offset-md-6 col-md-3">

                                    <button type="submit" class="btn btn-primary btn-block">{{ translateKeyword('Add_Service_Type')}}</button>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

