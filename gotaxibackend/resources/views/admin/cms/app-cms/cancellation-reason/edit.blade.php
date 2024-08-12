@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Edit Cancellation ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i>
                    {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('edit-cancellation-reason') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{ route('admin.cancellation.update', $reason->id) }}" method="POST"
                    enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
                    @method('put')
                    <ul class="nav nav-tabs" id="myInnerTab" role="tablist" style="margin-bottom: 10px">
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
                            @php($translation = $reason->translations->where('language_id', $language->id)->first())
                            <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}" id="{{ $language->name }}"
                                role="tabpanel">
                                <div class="col-12 mt-1">
                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('cancellation-reason') }}</label>
                                        <div class="col-xs-10">
                                            @if ($index === 0)
                                                {{-- Parent reason --}}
                                                <input type="text" class="form-control"
                                                    name="reason_{{ $language->id }}" required
                                                    id="reason_{{ $language->id }}"
                                                    placeholder="{{ translateKeyword('cancellation-reason') }}..."
                                                    value="{{ old('reason_' . $language->id, $reason->reason) }}">
                                            @else
                                                <input type="text" class="form-control"
                                                    name="reason_{{ $language->id }}" {{ $index === 0 ? 'required' : '' }}
                                                    id="reason_{{ $language->id }}"
                                                    placeholder="{{ translateKeyword('cancellation-reason') }}..."
                                                    value="{{ old('reason_' . $language->id, $translation ? $translation->reason : '') }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group row">
                            <label for="name" class="col-xs-12 col-form-label">{{ translateKeyword('type') }}</label>
                            <div class="col-xs-10">
                                <select class="form-control" name="type"
                                    {{ $index === 0 ? 'required' : '' }} id="type"
                                    placeholder="{{ translateKeyword('type') }}...">
                                    <option value="USER" @if ($reason->type == 'USER') selected @endif>User</option>
                                    <option value="DRIVER" @if ($reason->type == 'DRIVER') selected @endif>Driver</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit"
                                class="btn btn-primary">{{ translateKeyword('update') }}</button>
                            <a href="{{ route('admin.cms.app') }}"
                                class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
