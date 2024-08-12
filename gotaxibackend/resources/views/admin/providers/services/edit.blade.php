@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Update Provider Service')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            @include('common.notify')

            <div class="box box-block bg-white border-radius-10">
                <div class="row">
                    <div class="col-xs-12">
                        <fieldset>
                            <form action="{{ route('admin.provider.service_type.update', [$Service->provider_id, $Service->id]) }}"
                                  method="POST">
                                <h5>{{ translateKeyword('Update_Service_Type')}}</h5>
                                {{ csrf_field() }}
                                <div class="row mt-4 mb-2">
                                    <div class="col-xs-4">
                                        <label for="provider_name" class="col-xs-4 pl-0">{{ translateKeyword('service_type')}}</label>
                                        <select class="form-control input" name="service_type" required>
                                            @forelse($ServiceTypes as $Type)
                                                <option value="{{ $Type->id }}"
                                                        @if($Type->id == $Service->service_type_id) selected @endif>{{ $Type->name }}</option>
                                            @empty
                                                <option>- Please Create a Service Type -</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2 mb-2">
                                    <div class="col-xs-4">
                                        <label for="provider_name" class="col-xs-4 pl-0">{{ translateKeyword('service_number')}}</label>
                                        <input type="text" required name="service_number" class="form-control"
                                               value="{{ $Service->service_number }}"
                                               placeholder="Number (CY 98769)" readonly>
                                    </div>
                                </div>
                                <div class="row mt-2 mb-2">
                                    <div class="col-xs-4">
                                        <label for="provider_name" class="col-xs-4 pl-0">{{ translateKeyword('service_model')}}</label>
                                        <input type="text" required name="service_model" class="form-control"
                                               value="{{ $Service->service_model }}"
                                               placeholder="Model (Audi R8 - Black)" readonly>
                                    </div>
                                </div>
                                @if(Setting::get('vehicle_weightage', 0) == 1)
                                    <div class="row mt-2 mb-2">
                                        <div class="col-xs-4">
                                            <label for="provider_name" class="col-xs-12 pl-0">{{ translateKeyword('service-weightage-allowed(kg)')}}</label>
                                            <input type="number" required name="service_weight_allowed_kg"
                                                   class="form-control"
                                                   value="{{ $Service->service_weight_allowed_kg }}"
                                                   placeholder="10" min="0">
                                        </div>
                                    </div>
                                @endif
                                <div class="col-xs-3 mt-2 mb-2 pl-2">
                                    <button class="btn btn-primary btn-block" type="submit">{{ translateKeyword('update')}}</button>
                                </div>
                                <div class="col-xs-3 mt-2 mb-2 pl-2">
                                    <a href="{{ URL::previous() }}" class="btn btn-warning"> <i
                                                class="fas fa-arrow-left"></i> {{ translateKeyword('go-back')}}</a>

                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection