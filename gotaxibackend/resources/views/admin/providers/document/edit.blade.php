@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Provider Documents ')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="box box-block bg-white border-radius-10">
                <div class="row">
                    <div class="col">
                        <a href="{{ URL::previous() }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back')}}</a>
                        <a href="{{ $Document->url }}" class="btn btn-success pull-right" target="_blank" download="{{ $Document->provider->first_name . ' ' . $Document->provider->last_name . ' | ' . $Document->document->name }}"> {{ translateKeyword('download')}}</a>
                    </div>
                </div>

                <h5 class="mb-1">{{ translateKeyword('driver_name')}}: {{ $Document->provider->first_name }} {{ $Document->provider->last_name }}</h5>
                <h5 class="mb-1">{{ translateKeyword('document')}}: {{ $Document->document->name }}</h5>
                <h5 class="mb-1">{{ translateKeyword('expiry-required')}}: {{ $Document->document->expiry_required }}</h5>
                @if ($Document->document->expiry_required == 'YES')
                <h5 class="mb-1">{{ translateKeyword('expiry-date')}}: {{ $Document->expiry_date? $Document->expiry_date->toFormattedDateString() : null }}</h5>
                @endif
                <embed src="{{ $Document->url }}" width="100%"/>


                <div class="row">
                    @if ($Document->status == 'ASSESSING')
                    <div class="col-xs-6">
                        <form action="{{ route('admin.provider.document.update', [$Document->provider->id, $Document->id]) }}"
                              method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <button class="btn btn-block btn-primary" type="submit">{{ translateKeyword('approve')}}</button>
                        </form>
                    </div>
                    @endif
                    
                    <div class="col-xs-6">
                        <form action="{{ route('admin.provider.document.destroy', [$Document->provider->id, $Document->id]) }}"
                              method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-block btn-danger" type="submit">{{ translateKeyword('delete')}}</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection