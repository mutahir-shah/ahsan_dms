@extends('user.layout.base')

@section('title', 'Add Card ')

@section('content')

    <div class="col-md-12">
        <div class="dash-content">
            <div class="row no-margin">
                <div class="col-md-12">
                    <h4 class="page-title">{{ translateKeyword('card_add') }}</h4>
                </div>
            </div>

            <div class="row no-margin ride-detail">
                <div class="col-md-12">
                    @include('common.notify')
                    <div class="row no-margin edit-pro">
                        <form action="{{route('web.card.store')}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group col-md-6">
                                <label>{{ translateKeyword('Card No')}}.</label>
                                <input type="text" class="form-control" name="card_number" required minlength="16" maxlength="16"
                                       placeholder="Enter card no...">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ translateKeyword('Expiry Year')}}</label>
                                <input type="text" class="form-control" name="exp_year" required minlength="4" maxlength="4"
                                       placeholder="{{ translateKeyword('Enter year')}}...">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ translateKeyword('Expiry Month')}}</label>
                                <input type="text" class="form-control" name="exp_month" required minlength="2" maxlength="2"
                                       placeholder="Enter month...">
                            </div>
                            <div class="form-group col-md-6">
                                <label>CVC</label>
                                <input type="text" class="form-control" name="cvc" required minlength="3" maxlength="3"
                                       placeholder="Enter CVC...">
                            </div>
                            <div class="col-md-3 pull-right">
                                <button type="submit" class="form-sub-btn big">{{ translateKeyword('save') }}</button>
                            </div>
                            <div class="col-md-3 pull-right">
                                <a href="{{ route('web.cards') }}" class="form-sub-btn big btn-default">{{ translateKeyword('cancel')}}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
