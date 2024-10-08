@extends('account.layout.base')

@section('title', 'Update Service Type ')

@section('content')
    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <a href="{{ url('account/approved_account') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> Back</a>

                <h5 style="margin-bottom: 2em;">Update User</h5>

                <form class="form-horizontal" action="{{ route('account.bank.update', $service->id) }}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}


                    <input type="hidden" name="_method" value="PATCH">
                    @if ($service->type == 'bank')
                        <div class="form-group row">
                            <label for="name" class="col-xs-2 col-form-label">Account Name</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ $service->account_name }}"
                                       name="account_name" required id="account_name" placeholder="Account Name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="provider_name" class="col-xs-2 col-form-label">Bank Name</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ $service->bank_name }}"
                                       name="bank_name" required id="bank_name" placeholder="Bank Name">
                            </div>
                        </div>
                    @endif
                    @if ($service->type == 'paypal')
                        <div class="form-group row">
                            <label for="name" class="col-xs-2 col-form-label">Paypal Id</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ $service->paypal_id }}"
                                       name="account_name" required id="paypal_id" placeholder="Paypal Id">
                            </div>
                        </div>
                    @endif
                    <!-- <div class="form-group row">
                        
                        <label for="image" class="col-xs-2 col-form-label">Picture</label>
                        <div class="col-xs-10">
                            @if (isset($service->image))
                        <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{ $service->image }}">

                    @endif
                    <input type="file" accept="image/*" name="image" class="dropify form-control-file" id="image" aria-describedby="fileHelp">
                </div>
            </div>
-->
                    <!-- <div class="form-group row">
                        <label for="fixed" class="col-xs-2 col-form-label">Base Price ({{ currency('') }})</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $service->fixed }}" name="fixed" required id="fixed" placeholder="Base Price">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="distance" class="col-xs-2 col-form-label">Base Distance (0Mile)</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $service->distance }}" name="distance" required id="distance" placeholder="Base Distance">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="minute" class="col-xs-2 col-form-label">Unit Time Pricing  ({{ currency() }})</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $service->minute }}" name="minute" required id="minute" placeholder="Unit Time Pricing">
                        </div>
                    </div> -->

                    <!-- <div class="form-group row">
                        <label for="price" class="col-xs-2 col-form-label">Unit Distance Price (Miles)</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $service->price / 0.6 }}" name="price" required id="price" placeholder="Unit Distance Price">
                        </div>
                    </div> -->

                    <div class="form-group row">
                        <label for="capacity" class="col-xs-2 col-form-label">Account Number</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $service->account_number }}"
                                   name="account_number" maxlength="13" required id="capacity"
                                   placeholder="Account Number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="capacity" class="col-xs-2 col-form-label">Rounting Number</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $service->routing_number }}"
                                   name="routing_number" required id="routing_number" placeholder="Rounting Number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="capacity" class="col-xs-2 col-form-label">Country</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $service->country }}" name="country"
                                   required id="country" placeholder="Country">
                        </div>
                    </div>

                    <!-- <div class="form-group row">
                        <label for="calculator" class="col-xs-2 col-form-label">Pricing Logic</label>
                        <div class="col-xs-10">
                            <select class="form-control" id="calculator" name="calculator">
                                <option value="MIN" @if ($service->calculator == 'MIN')
                        selected
                    @endif>{{ translateKeyword('MIN') }}</option>
                                <option value="HOUR" @if ($service->calculator == 'HOUR')
                        selected
                    @endif>{{ translateKeyword('HOUR') }}</option>
                                <option value="DISTANCE" @if ($service->calculator == 'DISTANCE')
                        selected
                    @endif>{{ translateKeyword('DISTANCETIER') }}</option>
                                <option value="DISTANCE" @if ($service->calculator == 'DISTANCETIER')
                        selected
                    @endif>{{ translateKeyword('DISTANCE') }}</option>
                                <option value="DISTANCEMIN" @if ($service->calculator == 'DISTANCEMIN')
                        selected
                    @endif>{{ translateKeyword('DISTANCEMIN') }}</option>
                                <option value="DISTANCEHOUR" @if ($service->calculator == 'DISTANCEHOUR')
                        selected
                    @endif>{{ translateKeyword('DISTANCEHOUR') }}</option>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <a href="{{ url('admin/approved_account') }}" class="btn btn-danger btn-block">Cancel</a>
                        </div>
                        <div class="col-xs-12 col-sm-6 offset-md-6 col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Update Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
