@extends('provider.layout.app')

@section('content')
    <div class="pro-dashboard-head">
        <div class="container">
            <a href="#" class="pro-head-link active">Profile</a>
            <a href="{{ route('provider.documents.index') }}" class="pro-head-link">Manage Documents</a>
            <a href="{{ route('provider.location.index') }}" class="pro-head-link">Update Location</a>
            <a href="{{ route('provider.change.password') }}" class="pro-head-link">Change Password</a>
        </div>
    </div>
    <!-- Pro-dashboard-content -->
    <div class="pro-dashboard-content gray-bg">
        <div class="profile pad50">
            <!-- Profile head -->

            <div class="container">
                <div class="profile-head row no-margin">
                    <div class="prof-head-left col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <img class="provider-dp"
                            src="{{ Auth::guard('provider')->user()->avatar ? asset('storage/' . Auth::guard('provider')->user()->avatar) : asset('asset/img/avatar5.png') }}" />
                    </div>
                </div>
            </div>

            <!-- Profile-content -->
            <div class="profile-content gray-bg ">
                <div class="container">
                    <div class="row no-margin">
                        <div class="col-lg-7 col-md-7 col-sm-8 col-xs-12 no-padding">
                            <form class="profile-form" action="{{ route('provider.profile.update') }}" method="POST"
                                enctype="multipart/form-data" role="form">
                                {{ csrf_field() }}
                                <!-- Prof-form-sub-sec -->
                                <div class="prof-form-sub-sec">
                                    <div class="row no-margin">
                                        <div class="prof-sub-col col-sm-6 col-xs-12 no-left-padding">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" placeholder="Contact Number"
                                                    name="first_name"
                                                    value="{{ Auth::guard('provider')->user()->first_name }}">
                                            </div>
                                        </div>
                                        <div class="prof-sub-col col-sm-6 col-xs-12 no-right-padding">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" placeholder="Contact Number"
                                                    name="last_name"
                                                    value="{{ Auth::guard('provider')->user()->last_name }}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row no-margin">
                                        <div class="prof-sub-col col-sm-6 col-xs-12 no-left-padding">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" class="form-control" required
                                                    placeholder="Contact Number" name="mobile" disabled
                                                    value="{{ Auth::guard('provider')->user()->mobile }}">
                                            </div>
                                        </div>
                                        <div class="prof-sub-col col-sm-6 col-xs-12 no-right-padding">
                                            <div class="form-group no-margin">
                                                <label for="exampleSelect1">Language</label>
                                                <select class="form-control" name="language">
                                                    <option value="English">English</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of prof-sub-sec -->

                                <!-- Prof-form-sub-sec -->
                                <div class="prof-form-sub-sec border-top">


                                    <div class="row no-margin">
                                        <div class="prof-sub-col col-sm-6 col-xs-12 no-left-padding">
                                            <div class="form-group">
                                                <label>Avatar</label>
                                                <input type="file" class="form-control" name="avatar">
                                            </div>
                                        </div>
                                        <div class="prof-sub-col col-sm-6 col-xs-12 no-right-padding">
                                            <div class="form-group">
                                                <label>Service Type</label>
                                                <select class="form-control" name="services_type[]"  @if (Setting::get('multi_service_module', 0) == 1)
                                                multiple style="height: 100px"
                                            @endif>
                                                    <option value="">Select Service</option>
                                                    @foreach (get_all_service_types() as $type)
                                                        @php
                                                            $service_id = Auth::guard('provider')->user()->service ? Auth::guard('provider')->user()->service[0]->id : 0;
                                                        @endphp
                                                        <option @if ($service_id == $type->id) selected="selected" @endif
                                                            value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row no-margin">
                                         @if (Setting::get('tax_tps_info_field', 0) == 1)
                                        <div class="prof-sub-col col-sm-6 col-xs-12 no-left-padding">
                                            <div class="form-group no-margin">
                                                <label>Number TPS - Tax Info</label>
                                                <input type="text" class="form-control" placeholder="Number TPS - Tax Info"
                                                    name="tax_tps_info" 
                                                    value="{{ Auth::guard('provider')->user()->tax_tps_info ? Auth::guard('provider')->user()->tax_tps_info : '' }}">
                                            </div>
                                        </div>
                                        @endif
                                        @if (Setting::get('tax_tvq_info_field', 0) == 1)
                                        <div class="prof-sub-col col-sm-6 col-xs-12 no-right-padding">
                                            <div class="form-group">
                                                <label>Number TVQ - Tax Info</label>
                                                <input type="text" placeholder="Number TVQ - Tax Info" class="form-control"
                                                    name="tax_tvq_info" 
                                                    value="{{ Auth::guard('provider')->user()->tax_tvq_info ? Auth::guard('provider')->user()->tax_tvq_info : '' }}">
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                    <div class="row no-margin">
                                        <div class="prof-sub-col col-sm-6 col-xs-12 no-left-padding">
                                            <div class="form-group no-margin">
                                                <label>Car Number</label>
                                                <input type="text" class="form-control" placeholder="Car Number"
                                                    name="service_number" disabled
                                                    value="{{ Auth::guard('provider')->user()->service[0]->service_number ? Auth::guard('provider')->user()->service[0]->service_number : '' }}">
                                            </div>
                                        </div>
                                        <div class="prof-sub-col col-sm-6 col-xs-12 no-right-padding">
                                            <div class="form-group">
                                                <label>Car Model</label>
                                                <input type="text" placeholder="Car Model" class="form-control"
                                                    name="service_model" disabled
                                                    value="{{ Auth::guard('provider')->user()->service[0]->service_model ? Auth::guard('provider')->user()->service[0]->service_model : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of prof-sub-sec -->

                                <!-- Prof-form-sub-sec -->
                                <div class="prof-form-sub-sec border-top">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <button type="submit" class="btn btn-block btn-primary update-link">Update
                                        </button>
                                    </div>
                                </div>
                                <!-- End of prof-sub-sec -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
