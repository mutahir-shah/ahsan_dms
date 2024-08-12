@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Add Document ')


@section('content')



    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <a href="{{ route('admin.document.index') }}" class="btn btn-default pull-right"><i
                        class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('add_Document') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{ route('admin.document.store') }}" method="POST"
                    enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}

                    <ul class="nav nav-tabs" id="myInnerTab" role="tablist" style="margin: 10px 0 10px 10px">
                        @php($languages = getLanguages())
                        @foreach ($languages as $index => $language)
                            <li class="nav-item">
                                <a class="nav-link {{ $index === 0 ? 'active' : '' }}" data-toggle="tab"
                                    href="#{{ $language->name }}" role="tab"
                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                    {{ $language->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach ($languages as $index => $language)
                            <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}"
                                id="{{ $language->name }}" role="tabpanel">
                                <div class="col-12 mt-1">
                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('document_name') }}</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text" value="{{ old('name'. $language->id) }}" name="name_{{ $language->id }}" {{ $index === 0 ? 'required' : '' }}
                                                id="name_{{ $language->id }}" placeholder="{{ translateKeyword('document_name') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>

                    <div class="form-group row">
                        <label for="name"
                            class="col-xs-12 col-form-label">{{ translatekeyword('document_type') }}</label>
                        <div class="col-xs-10">
                            <select name="type" class="form-control">
                                <option value="USER">{{ translateKeyword('User') }} </option>
                                <option value="DRIVER">{{ translateKeyword('provider') }}</option>
                                <option value="VEHICLE">{{ translateKeyword('vehicle') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name"
                            class="col-xs-12 col-form-label">{{ translateKeyword('expiry-required') }}</label>
                        <div class="col-xs-10">
                            <select name="expiry_required" class="form-control">
                                <option value="NO" selected>{{ translateKeyword('no') }}</option>
                                <option value="YES">{{ translateKeyword('yes') }}</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('add_Document') }}</button>
                            <a href="{{ route('admin.document.index') }}"
                                class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inner tabs
            const innerTabs = document.querySelectorAll('#myInnerTab .nav-link');

            innerTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('href');
                    document.querySelector(target).classList.add('show', 'active');
                    innerTabs.forEach(t => {
                        if (t !== tab) {
                            const paneId = t.getAttribute('href');
                            document.querySelector(paneId).classList.remove('show',
                                'active');
                        }
                    });
                });
            });
        });
    </script>

@endsection
