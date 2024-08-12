@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Add Blog ')

@section('content')
    <style>
        .input-group-addon {
            width: 35px !important;
            border-radius: 5px;
        }
    </style>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">

                <a href="{{ route('admin.blogs.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i>
                    {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('Add-Blog') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="picture" class="col-xs-12 col-form-label">{{ translateKeyword('picture') }}</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="file" name="picture" required id="picture">
                                </div>
                            </div>
                            <ul class="nav nav-tabs" id="myInnerTab" role="tablist" style="margin: 10px 0 10px 10px">
                                @php($languages = getLanguages())
                                @foreach ($languages as $index => $language)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}" data-toggle="tab"
                                            href="#{{ $language->name }}_about" role="tab"
                                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                            {{ $language->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                
                                @foreach ($languages as $index => $language)
                                    <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}"
                                        id="{{ $language->name }}_about" role="tabpanel">
                                        <div class="form-group row">
                                            <label for="title_{{ $language->name }}"
                                                class="col-xs-12 col-form-label">{{ translateKeyword('Title') }}</label>
                                            <div class="col-xs-10">
                                                <input class="form-control" type="text" value="{{ old('title_' . $language->id) }}"
                                                    name="title_{{ $language->id }}" {{ $index === 0 ? 'required' : '' }}
                                                    id="title_{{ $language->id }}"
                                                    placeholder="{{ $language->name }} {{ translateKeyword('Title') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description_{{ $language->name }}"
                                                class="col-xs-12 col-form-label">{{ translateKeyword('Description') }}</label>
                                            <div class="col-xs-10">
                                                <textarea name="description_{{ $language->id }}" id="description_{{ $language->id }}" {{ $index === 0 ? 'required' : '' }}
                                                    placeholder="{{ $language->name }} {{ translateKeyword('Description') }}">{{ old('description_' . $language->id) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('Add-Blog') }}</button>
                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        @foreach ($languages as $language)
            CKEDITOR.replace('description_{{ $language->id }}');
        @endforeach
    </script>
@endsection
