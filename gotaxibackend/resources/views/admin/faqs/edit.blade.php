@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Update Faq ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <a href="{{ route('admin.cms.app') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i>
                    {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('update-faq') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{ route('admin.faqs.update', $faqs->id) }}" method="POST"
                    enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PATCH">
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
                            @php($translation = $faqs->translations->where('language_id', $language->id)->first())
                            <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}" id="{{ $language->name }}"
                                role="tabpanel">
                                <div class="col-12 mt-1">
                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-xs-2 col-form-label">{{ translateKeyword('question') }}</label>
                                        <div class="col-xs-10">
                                            @if ($index === 0)
                                                {{-- Parent reason --}}
                                                <input type="text" class="form-control"
                                                    name="question_{{ $language->id }}"
                                                    {{ $index === 0 ? 'required' : '' }} id="question_{{ $language->id }}"
                                                    placeholder="{{ translateKeyword('question') }}..."
                                                    value="{{ old('question_' . $language->id, $faqs->question) }}">
                                            @else
                                                <input type="text" class="form-control"
                                                    name="question_{{ $language->id }}"
                                                    {{ $index === 0 ? 'required' : '' }} id="question_{{ $language->id }}"
                                                    placeholder="{{ translateKeyword('question') }}..."
                                                    value="{{ old('question_' . $language->id, $translation ? $translation->question : '') }}">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-xs-2 col-form-label">{{ translateKeyword('answer') }}</label>
                                        <div class="col-xs-10">
                                            @if ($index === 0)
                                                <textarea class="form-control" name="answer_{{ $language->id }}" {{ $index === 0 ? 'required' : '' }}
                                                    id="answer_{{ $language->id }}" placeholder="{{ translateKeyword('answer') }}...">{{ old('answer_' . $language->id, $faqs->answer) }}</textarea>
                                            @else
                                                    <textarea class="form-control" name="answer_{{ $language->id }}" {{ $index === 0 ? 'required' : '' }}
                                                        id="answer_{{ $language->id }}" placeholder="{{ translateKeyword('answer') }}...">{{ old('answer_' . $language->id, $translation ? $translation->answer : '') }}</textarea>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    <div class="form-group row">
                        <label for="name" class="col-xs-2 col-form-label">{{ translateKeyword('faq-type') }}</label>
                        <div class="col-xs-10">
                            <select name="type" class="form-control">
                                <option value="USER" @if ($faqs->type == 'USER') selected @endif>
                                    {{ translateKeyword('User') }}
                                </option>
                                <option value="DRIVER" @if ($faqs->type == 'DRIVER') selected @endif>
                                    {{ translateKeyword('provider') }}
                                </option>
                            </select>
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('update-faq') }}</button>
                            <a href="{{ route('admin.cms.app') }}"
                                class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
