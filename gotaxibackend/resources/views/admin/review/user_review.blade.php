@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'User Reviews ')

@section('content')
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="box box-block bg-white border-radius-10">
                <h5 class="mb-1">{{ translateKeyword('reviews') }}</h5>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                        <tr>
                            <th>{{ translateKeyword('reviews') }}</th>
                            <th>{{ translateKeyword('request_id') }}</th>
                            <th>{{ translateKeyword('User_Name') }}</th>
                            <th>{{ translateKeyword('user_ratings') }}</th>
                            <th>{{ translateKeyword('user-comment') }}</th>
                            <th>{{ translateKeyword('provider_name') }}</th>
                            <th>{{ translateKeyword('provider_ratings') }}</th>
                            <th>{{ translateKeyword('driver-comment') }}</th>
                            <th>{{ translateKeyword('date') }} & {{ translateKeyword('time') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Reviews as $index => $review)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $review->request_id }}</td>
                                <td>
                                    @if (isset($review->user->first_name))
                                        {{ $review->user->first_name }} {{ $review->user->last_name }}
                                    @else
                                        "N/A"
                                    @endif
                                </td>
                                <td>{{ $review->user_rating }}
                                    {{-- <div className="rating-outer">
                                    <input type="hidden" value="{{$review->user_rating}}" name="rating" class="rating"/>
                                </div> --}}
                                </td>
                                <td>{{ $review->user_comment }}</td>
                                <td>
                                    @if (isset($review->provider->first_name))
                                        {{ $review->provider->first_name }} {{ $review->provider->last_name }}
                                    @else
                                        "N/A"
                                    @endif

                                </td>
                                <td>{{ $review->provider_rating }}
                                    {{-- <div className="rating-outer">
                                    <input type="hidden" value="{{$review->provider_rating}}" name="rating" class="rating"/>
                                </div> --}}
                                </td>
                                <td>{{ $review->provider_comment }}</td>
                                <td>{{ $review->created_at }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ translateKeyword('reviews') }}</th>
                            <th>{{ translateKeyword('request_id') }}</th>
                            <th>{{ translateKeyword('User_Name') }}</th>
                            <th>{{ translateKeyword('user_ratings') }}</th>
                            <th>{{ translateKeyword('user-comment') }}</th>
                            <th>{{ translateKeyword('provider_name') }}</th>
                            <th>{{ translateKeyword('provider_ratings') }}</th>
                            <th>{{ translateKeyword('driver-comment') }}</th>
                            <th>{{ translateKeyword('date') }} & {{ translateKeyword('time') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>

    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
@endsection
