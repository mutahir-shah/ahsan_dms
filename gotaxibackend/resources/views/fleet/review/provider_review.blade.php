@extends('fleet.layout.basecode')
@extends('admin.layout.base2')


@section('title', 'User Reviews ')

@section('content')
    <link rel="stylesheet" href="{{url('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="box box-block bg-white">
                <h5 class="mb-1">Reviews</h5>
                <table id="table-1" class="table table-bordered table-hover" style="overflow: scroll;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Request ID</th>
                        <th>User Name</th>
                        <th>User Rating</th>
                        <th>User Comment</th>
                        <th>Driver Name</th>
                        <th>Driver Rating</th>
                        <th>Driver Comment</th>
                        <th>Date & Time</th>
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
                                <div className="rating-outer">
                                    <input type="hidden" value="{{$review->user_rating}}" name="rating" class="rating"/>
                                </div>
                            </td>
                            <td>{{$review->user_comment}}</td>
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
                            <td>{{$review->provider_comment}}</td>
                            <td>{{$review->created_at}}</td>

                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Request ID</th>
                        <th>User Name</th>
                        <th>User Rating</th>
                        <th>User Comment</th>
                        <th>Driver Name</th>
                        <th>Driver Rating</th>
                        <th>Driver Comment</th>
                        <th>Date & Time</th>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>


    <script src="{{url('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
@endsection