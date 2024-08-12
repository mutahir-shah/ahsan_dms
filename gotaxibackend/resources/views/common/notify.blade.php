@if (count($errors) > 0)
    {{-- @foreach ($errors->all() as $error)
    {{ $error }}
    @endforeach --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            {{-- <a href="javascript:;" class="close" data-dismiss="alert" aria-label="close">&times;</a> --}}
            <p class="m-0"><strong>{{ translateKeyword('Error!') }}</strong></p>
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endif

@if(Session::has('flash_error'))
    <div class="alert alert-danger alert-dismissible">
        {{-- <a href="javascript:;" class="close" data-dismiss="alert" aria-label="close">&times;</a> --}}
        <p class="m-0"><strong>{{ translateKeyword('Error!') }}</strong> {{ Session::get('flash_error') }}</p>
    </div>

@endif

@if(Session::has('flash_success'))
    <div class="alert alert-success alert-dismissible">
        <a href="javascript:" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <p class="m-0"><strong>{{ translateKeyword('Success!') }}</strong> {{ Session::get('flash_success') }}</p>
    </div>
@endif

@if(Session::has('flash_info'))
    <div class="alert alert-info alert-dismissible">
        <a href="javascript:" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <p class="m-0"><strong>{{ translateKeyword('Info!')}}</strong> {{ Session::get('flash_info') }}</p>
    </div>
@endif

{{-- @if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <a href="javascript:;" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <p class="m-0"><strong>Error!</strong></p>
        <ul class="m-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}