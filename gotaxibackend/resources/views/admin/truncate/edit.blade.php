@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Update Faq ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back')}}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('update-faq')}}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('admin.faqs.update', $faqs->id )}}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group row">
                        <label for="question" class="col-xs-2 col-form-label">{{ translateKeyword('question')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $faqs->question }}" name="question" required
                                   id="question" placeholder="{{ translateKeyword('question')}}...">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="answer" class="col-xs-2 col-form-label">{{ translateKeyword('answer')}}</label>
                        <div class="col-xs-10">
                            <textarea class="form-control" name="answer" required
                                   id="answer" placeholder="{{ translateKeyword('answer')}}...">{{ $faqs->answer }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-xs-2 col-form-label">{{ translateKeyword('faq-type')}}</label>
                        <div class="col-xs-10">
                            <select name="type" class="form-control">
                                <option value="USER" @if($faqs->type == 'USER') selected @endif>{{ translateKeyword('User')}} 
                                </option>
                                <option value="DRIVER" @if($faqs->type == 'DRIVER') selected @endif>{{ translateKeyword('provider')}} 
                                </option>
                            </select>
                        </div>
                    </div>

                    

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('update-faq') }}</button>
                            <a href="{{route('admin.faqs.index')}}" class="btn btn-default">{{ translateKeyword('cancel')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
