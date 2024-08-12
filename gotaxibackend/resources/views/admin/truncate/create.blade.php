@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Add Faq ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back')}}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('add-faq')}}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('admin.faqs.store')}}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label for="name" class="col-xs-12 col-form-label">{{ translateKeyword('question')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('question') }}" name="question" required
                                   id="question" placeholder="{{ translateKeyword('question')}}...">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-xs-12 col-form-label">{{ translateKeyword('answer')}}</label>
                        <div class="col-xs-10">
                            <textarea class="form-control" name="answer" required
                                   id="answer" placeholder="{{ translateKeyword('answer')}}...">{{ old('answer') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-xs-12 col-form-label">{{ translateKeyword('type')}}</label>
                        <div class="col-xs-10">
                            <select name="type" class="form-control">
                                <option value="USER">{{ translateKeyword('User')}}</option>
                                <option value="DRIVER">{{ translateKeyword('provider')}}</option>
                            </select>
                        </div>
                    </div>

                    


                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('add-faq')}}</button>
                            <a href="{{route('admin.faqs.index')}}" class="btn btn-default">{{ translateKeyword('cancel')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
