@extends('user.layout.base')

@section('title', 'Promotion')

@section('content')

    <div class="col-md-12">
        <div class="dash-content">
            <div class="row no-margin">
                <div class="col-md-12">
                    <h4 class="page-title">{{ translateKeyword('promotion') }}</h4>
                </div>
            </div>
            @include('common.notify')
            <div class="row no-margin payment">
                <div class="col-md-12">
                    <h5 class="btm-border"><strong>{{ translateKeyword('Coupons') }}</strong> <a href="#"
                                                                                     class="sub-right pull-right"
                                                                                     data-toggle="modal"
                                                                                     data-target="#add-promotion-modal">{{ translateKeyword('add_promocode') }}</a>
                    </h5>

                    @forelse($promocodes as $promo)
                        <div class="pay-option">
                            <h6>
                                <img src="{{asset('asset/img/low-cost.png')}}"> {{$promo->promocode->promo_code}}
                                <a href="#" class="default">{{$promo->status}}</a>
                            </h6>
                        </div>

                    @empty
                        <div class="pay-option">
                            <h6 class="text-center">{{ translateKeyword('no_available') }}</h6>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div id="add-promotion-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ translateKeyword('add_promocode') }}</h4>
                </div>
                <form id="promocodes-form" action="{{ route('promocodes.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row no-margin" id="card-payment">
                            <div class="form-group col-md-12 col-sm-12">
                                <label>{{ translateKeyword('Promocode') }}</label>
                                <input autocomplete="off" name="promocode" required type="text" class="form-control"
                                       placeholder="{{ translateKeyword('add_promocode') }}">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">{{ translateKeyword('add_promocode') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection