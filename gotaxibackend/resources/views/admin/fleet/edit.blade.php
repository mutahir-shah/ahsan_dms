@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Update Fleet ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <a href="{{ route('admin.fleet.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('update_fleet') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('admin.fleet.update', $fleet->id )}}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group row">
                        <label for="name" class="col-xs-2 col-form-label">{{ translateKeyword('full_name') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $fleet->name }}" name="name" required
                                   id="name" placeholder="{{ translateKeyword('full_name') }}">
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label for="company_name" class="col-xs-2 col-form-label">Company Name</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ $fleet->company_name }}" name="company_name"
                                     required id="company_name" placeholder="Company Name">
                            </div>
                    </div> --}}
                    {{-- @if (Setting::get('partner_company_info') == 1) --}}
                    <div class="form-group row">
                        <label for="company" class="col-xs-2 col-form-label">{{ translateKeyword('company_name') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $fleet->company }}" name="company"
                                   required id="company" placeholder="{{ translateKeyword('company_name') }}">
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="company_address" class="col-xs-2 col-form-label">Company Address</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $fleet->company_address }}" name="company_address"
                            required id="company_address" placeholder="Company Address">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="company_vat" class="col-xs-2 col-form-label">Company VAT</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $fleet->company_vat }}" name="company_vat"
                                required id="company_vat" placeholder="Company VAT">
                        </div>
                    </div> --}}
                    {{-- @endif --}}

                    @if (Setting::get('fleet_manager_address_nif') == 1)

                        <div class="form-group row">
                            <label for="address" class="col-xs-2 col-form-label">{{ translateKeyword('address') }}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ $fleet->address }}" name="address"
                                       required id="address" placeholder="{{ translateKeyword('address') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nif" class="col-xs-2 col-form-label">{{ translateKeyword('NIF') }}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ $fleet->nif }}" name="nif"
                                       required id="nif" placeholder="{{ translateKeyword('NIF') }}">
                            </div>
                        </div>

                    @endif
                    @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                        <div class="form-group row">
                            <label for="mobile" class="col-xs-12 col-form-label">{{ translateKeyword('zone') }}</label>
                            <div class="col-xs-10">
                                <select name="zone_id" class="form-control">
                                    <option value="0" selected>{ translateKeyword('no-zone') }}</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif


                    <div class="form-group row">

                        <label for="logo" class="col-xs-2 col-form-label">{{ translateKeyword('company_logo') }}</label>
                        <div class="col-xs-10">
                            @if(isset($fleet->logo))
                                <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                     src="{{img($fleet->logo)}}">
                            @endif
                            <input type="file" accept="image/*" name="logo" class="dropify form-control-file" id="logo"
                                   aria-describedby="fileHelp">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mobile" class="col-xs-2 col-form-label">{{ translateKeyword('mobile')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $fleet->mobile }}" name="mobile" required
                                   id="mobile" minlength="10" maxlength="15" placeholder="{{ translateKeyword('mobile')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('update_fleet_owner') }}</button>
                            <a href="{{route('admin.fleet.index')}}" class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
