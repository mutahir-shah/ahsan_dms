@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Provider Details ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <h4>{{ translateKeyword('Provider_Details')}}</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box bg-white user-1">
                            <?php $background = asset('admin/assets/img/photos-1/4.jpg'); ?>
                            <div class="u-img img-cover" style="background-image: url({{$background}});"></div>
                            <div class="u-content">
                                <div class="avatar box-64">
                                    <img class="b-a-radius-circle shadow-white" src="{{img($provider->picture)}}"
                                         alt="">
                                    <i class="status bg-success bottom right"></i>
                                </div>
                                <p class="text-muted">
                                    @if($provider->is_approved == 1)
                                        <span class="tag tag-success">{{ translateKeyword('Approved')}}</span>
                                    @else
                                        <span class="tag tag-success">{{ translateKeyword('Not_Approved')}}</span>
                                    @endif
                                </p>
                                <h5><a class="text-black"
                                       href="#">{{$provider->first_name}} {{$provider->last_name}}</a></h5>
                                @if (Setting::get('email_field', 0) == 1)
                                    <p class="text-muted">{{ translateKeyword('email')}} : {{$provider->email}}</p>
                                @endif
                                <p class="text-muted">{{ translateKeyword('mobile')}} : {{$provider->mobile}}</p>
                                <p class="text-muted">{{ translateKeyword('gender')}} : {{$provider->gender}}</p>
                                <p class="text-muted">{{ translateKeyword('address')}} : {{$provider->address}}</p>
                                <p class="text-muted">
                                    @if($provider->is_activated == 1)
                                        <span class="tag tag-warning">{{ translateKeyword('activated')}}</span>
                                    @else
                                        <span class="tag tag-warning">{{ translateKeyword('not-activated')}}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
