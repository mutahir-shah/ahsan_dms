@extends('fleet.layout.basecode')
@extends('admin.layout.base2')


@section('title', 'Update Provider ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <a href="{{ route('fleet.provider.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> Back</a>

                <h5 style="margin-bottom: 2em;">Update Provider</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('fleet.provider.update', $provider->id )}}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group row">
                        <label for="first_name" class="col-xs-2 col-form-label">First Name</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $provider->first_name }}"
                                   name="first_name" required id="first_name" placeholder="First Name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="last_name" class="col-xs-2 col-form-label">Last Name</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $provider->last_name }}" name="last_name"
                                   required id="last_name" placeholder="Last Name">
                        </div>
                    </div>

                    @if (Setting::get('partner_company_info') == 1)
                        <div class="form-group row">
                            <label for="company_name" class="col-xs-2 col-form-label">Company Name</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ $provider->company_name }}"
                                       name="company_name"
                                       required id="company_name" placeholder="Company Name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="company_address" class="col-xs-2 col-form-label">Company Address</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ $provider->company_address }}"
                                       name="company_address"
                                       required id="company_address" placeholder="Company Address">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="company_vat" class="col-xs-2 col-form-label">Company VAT</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ $provider->company_vat }}"
                                       name="company_vat"
                                       required id="company_vat" placeholder="Company VAT">
                            </div>
                        </div>

                    @endif

                    @if (Setting::get('address_driver', 0) == 1)
                                    <div class="form-group row">
                                        <label for="address" class="col-xs-12 col-form-label">Address</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text" value="{{ old('address', $provider->address) }}" name="address"
                                                required id="address" placeholder="Address">
                                        </div>
                                    </div>
                                @endif
                                @if (Setting::get('dob_driver', 0) == 1)
                                    <div class="form-group row">
                                        <label for="dob" class="col-xs-12 col-form-label">Date of birth</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="date" value="{{ old('dob', $provider->dob) }}" name="dob"
                                                required id="dob" placeholder="DOB">
                                        </div>
                                    </div>
                                @endif
                                @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                                    <div class="form-group row">
                                        <label for="mobile" class="col-xs-12 col-form-label">Zone</label>
                                        <div class="col-xs-10">
                                            <select name="zone_id" class="form-control">
                                                <option value="0" selected>No Zone</option>
                                                @foreach ($zones as $zone)
                                                    <option value="{{ $zone->id }}" 
                                                        @if ($zone->id == $provider->zone_id)
                                                            selected
                                                        @endif
                                                    >{{ $zone->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif


                    <div class="form-group row">

                        <label for="picture" class="col-xs-2 col-form-label">Picture</label>
                        <div class="col-xs-10">
                            @if(isset($provider->picture))
                                <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                     src="{{$provider->picture}}">
                            @endif
                            <input type="file" accept="image/*" name="avatar" class="dropify form-control-file"
                                   id="picture" aria-describedby="fileHelp">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="mobile" class="col-xs-2 col-form-label">Mobile</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $provider->mobile }}" name="mobile"
                                   required id="mobile" minlength="10" maxlength="15" placeholder="Mobile">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">Update Provider</button>
                            <a href="{{route('fleet.provider.index')}}" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
