<?php

if (isset($zone)) {
    $zone_name = $zone->name;
    $zone_id = $zone->id;
} else {
    $zone_name = '';
    $zone_id = 0;
}

?>
<link href="https://bootstrapformhelpers.com/assets/css/bootstrap-formhelpers.min.css" rel="stylesheet"
      type="text/css"/>
<style>
    .bfh-selectbox {
        width: 100%;
    }
</style>
<div class="modal" id="zoneModel">
    <div class="modal-dialog" style="background: white;">
        <div class="modal-content">
            <form id="zoneForm">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="pull-left">{{ translateKeyword('add-location') }}</h4>
                    <span class="btn close  zone_close pull-right" id="zone_close" onClick="window.location.reload()"><i
                                class="fa fa-times"></i></span>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        {{-- <input type="hidden" name="country_id" id="country_id" /> --}}
                        <select class='form-control' name="country_name" onchange='getStates()'
                                id="country_name">
                            <option value='0'>{{ translateKeyword('Select Country')}}</option>
                            {{-- @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach --}}
                            {{-- <option v-for='data in countries' :value='data.id'>@{{ data.name }}</option> --}}
                        </select>
                    </div>
                    <div class="form-group">

                        {{-- <input type="hidden" name="state_id" id="state_id" /> --}}
                        <select class='form-control' onchange='getCities()' name="state_name"
                                id="state_name">
                            <option value='0'>{{ translateKeyword('Select State')}}</option>
                            {{-- <option v-for='data in states' :value='data.id'>@{{ data.name }}</option> --}}
                        </select>
                    </div>
                    <div class="form-group">
                        {{-- <input type="hidden" name="city_id" id="city_id" /> --}}
                        <select class='form-control' v-model='city' name="city_name" id="city_name"/>
                        <option value='0'>{{ translateKeyword('Select City')}}</option>
                        {{-- <option v-for='data in cities' :value='data.id'>@{{ data.name }}</option> --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Zone Name" name="zone_name"
                               value="{{ $zone_name }}"/>
                        <input type="hidden" name="zone_id" id="zone_id" value="{{ $zone_id }}"/>
                    </div>
                    <div class="form-group">
                        <h6 class="pull-left">{{ translateKeyword('currency')}}</h6><br/>
                        {{-- <input type="text" class="form-control" placeholder="Currency Name" name="currency_name" /> --}}
                        <select class="form-control bfh-currencies" name="currency_name"
                                data-currency="{{ Setting::get('currency', 'USD') }}"></select>
                    </div>
                    <h6 class="pull-left">{{ translateKeyword('Status')}}</h6><br/>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" value="active" name="status_name" checked>{{ translateKeyword('active')}}
                        </label>
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" value="inactive" name="status_name">{{ translateKeyword('In Active')}}
                        </label>
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" value="banned" name="status_name">{{ translateKeyword('Banned')}}
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-block" id="submit_zone_btn"><i class="fa fa-save"></i> {{ translateKeyword('SUBMIT')}}</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://bootstrapformhelpers.com/assets/js/bootstrap.min.js"></script>
<script src="https://bootstrapformhelpers.com/assets/js/bootstrap-formhelpers.min.js"></script>
