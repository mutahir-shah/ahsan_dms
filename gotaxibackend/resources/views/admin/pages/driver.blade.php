@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Pages ')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <h5>{{ translateKeyword('pages')}}</h5>

                <div className="row">
                    <form action="{{ route('admin.pages.update') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="page" value="page_driver">

                        <div class="row">
                            <div class="col-xs-12">
                                <textarea name="content" id="myeditor">{{ Setting::get('page_driver') }}</textarea>
                            </div>
                        </div>

                        <br>
                        @if(str_contains(config('app.url'), 'https://beegone.se'))
                            <h3 class="page-title">Swedish</h3>
                            <div class="row">
                                <div class="col-xs-12">
                                    <textarea name="content_swedish" id="myeditor1">{{ Setting::get('page_driver_swedish') }}</textarea>
                                </div>
                            </div>
                            <br>
                        @endif

                        @if ($edit_permission == 1)
                            <div class="row">
                                <div class="col-xs-12 col-md-3">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-block">{{ translateKeyword('cancel')}}</a>
                                </div>
                                <div class="col-xs-12 col-md-3 offset-md-6">
                                    <button type="submit" class="btn btn-primary btn-block">{{ translateKeyword('update')}}</button>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('myeditor');
        CKEDITOR.replace('myeditor1');
    </script>
@endsection