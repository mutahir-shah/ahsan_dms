@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Add Promocode ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <a href="{{ route('admin.promocode.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('add_promocode') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('admin.promocode.store')}}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label for="promo_code" class="col-xs-2 col-form-label">{{ translateKeyword('promocode') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" autocomplete="off" type="text" value="{{ old('promo_code') }}"
                                   name="promo_code" required id="promo_code" placeholder="{{ translateKeyword('promocode') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="discount" class="col-xs-2 col-form-label">{{ translateKeyword('discount') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" value="{{ old('discount') }}" name="discount"
                                   required id="discount" placeholder="{{ translateKeyword('discount') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="max_count" class="col-xs-2 col-form-label">{{ translateKeyword('max-use') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" value="{{ old('max_count') }}" name="max_count"
                                   required id="max_count" placeholder="{{ translateKeyword('max-use') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="expiration" class="col-xs-2 col-form-label">{{ translateKeyword('expiration') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="date" value="{{ old('expiration') }}" name="expiration"
                                   required id="expiration" placeholder="{{ translateKeyword('expiration') }}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('add_promocode') }}</button>
                            <a href="{{route('admin.promocode.index')}}" class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Get today's date
        var today = new Date();

        // Format the date to YYYY-MM-DD
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;

        // Set the min attribute to today's date
        document.getElementById('expiration').setAttribute('min', today);
    </script>
@endsection
