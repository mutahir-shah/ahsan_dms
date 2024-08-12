@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'User Details ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <h4>User Details</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box bg-white user-1 border-radius-10">
                            <?php $background = asset('admin/assets/img/photos-1/4.jpg'); ?>
                            <div class="u-img img-cover" style="background-image: url({{$background}});"></div>
                            <div class="u-content">
                                <div class="avatar box-64">
                                    <img class="b-a-radius-circle shadow-white" src="{{img($user->picture)}}" alt="">
                                    <i class="status bg-success bottom right"></i>
                                </div>
                                <h5><a class="text-black" href="#">{{$user->first_name}} {{$user->last_name}}</a></h5>
                                @if (Setting::get('email_field', 0) == 1)
                                    <p class="text-muted">{{ translateKeyword('email')}} : {{$user->email}}</p>
                                @endif
                                <p class="text-muted">{{ translateKeyword('mobile')}} : {{$user->mobile}}</p>
                                <p class="text-muted">{{ translateKeyword('gender')}} : {{$user->gender}}</p>
                                <p class="text-muted">{{ translateKeyword('Wallet_Balance')}} : {{currency($user->wallet_balance)}}</p>
                                <p class="text-muted">{{ translateKeyword('reward-points')}} : {{($user->reward_points)}}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
