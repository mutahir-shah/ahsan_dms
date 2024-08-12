@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Provider Reviews ')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">

            <div class="box box-block bg-white">
                <h5 class="mb-1">{{ translateKeyword('Provider_Reviews')}}</h5>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                    <tr>
                        <th>{{ translateKeyword('id') }}</th>
                        <th>{{ translateKeyword('request_id')}}</th>
                        <th>{{ translateKeyword('User_Name')}}</th>
                        <th>{{ translateKeyword('Provider_Name')}}</th>
                        <th>{{ translateKeyword('Rating')}}</th>
                        <th>{{ translateKeyword('Date_Time')}}</th>
                        <th>{{ translateKeyword('Comments')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($Reviews as $index => $review)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$review->request_id}}</td>
                            <td>
                                @if(isset($review->user->first_name))
                                    {{$review->user->first_name}} {{$review->user->last_name}}
                                @endif
                            </td>
                            <td>
                                @if(isset($review->provider->first_name))
                                    {{$review->provider->first_name}} {{$review->provider->last_name}}
                                @endif
                            </td>
                            <td>
                                <div className="rating-outer">
                                    <input type="hidden" value="{{$review->provider_rating}}" name="rating"
                                           class="rating"/>
                                </div>
                            </td>
                            <td>{{$review->created_at}}</td>
                            <td>{{$review->provider_comment}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>{{ translateKeyword('id') }}</th>
                        <th>{{ translateKeyword('request_id')}}</th>
                        <th>{{ translateKeyword('User_Name')}}</th>
                        <th>{{ translateKeyword('Provider_Name')}}</th>
                        <th>{{ translateKeyword('Rating')}}</th>
                        <th>{{ translateKeyword('Date_Time')}}</th>
                        <th>{{ translateKeyword('Comments')}}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
@endsection