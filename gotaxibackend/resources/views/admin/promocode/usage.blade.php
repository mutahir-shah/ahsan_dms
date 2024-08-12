@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Promocodes ')

@section('content')

    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="box box-block bg-white border-radius-10">
                <h5 class="mb-1">{{ translateKeyword('promocodes-usage') }}</h5>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                    <tr>
                        <th>{{ translateKeyword('id') }}</th>
                        <th>{{ translateKeyword('User_Name') }}</th>
                        <th>{{ translateKeyword('Promocode') }}</th>
                        <th>{{ translateKeyword('used-date') }}</th>
                        <th>{{ translateKeyword('status') }}</th>
                        {{-- <th>{{ translateKeyword('used_count') }}</th> --}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($promocodes as $index => $promo)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$promo->user ? $promo->user->first_name . ' ' . $promo->user->last_name : 'N/A'}}</td>

                            <td>{{$promo->promocode ? $promo->promocode->promo_code : 'N/A'}}</td>
                            <td>
                                {{date('d-m-Y',strtotime($promo->created_at))}}
                            </td>
                            <td>
                                    @if ($promo->status == 'ADDED')
                                    <span class="tag tag-primary">{{ $promo->status }}</span>
                                    @elseif ($promo->status == 'USED')
                                    <span class="tag tag-success">{{ $promo->status }}</span>
                                    @elseif ($promo->status == 'EXPIRED')
                                    <span class="tag tag-danger">{{ $promo->status }}</span>
                                    @endif
                            </td>
                            {{-- <td>
                                {{$promo->promocode ? promo_used_count($promo->promocode->id) : 'N/A'}}
                            </td> --}}
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>{{ translateKeyword('id') }}</th>
                        <th>{{ translateKeyword('User_Name') }}</th>
                        <th>{{ translateKeyword('Promocode') }}</th>
                        <th>{{ translateKeyword('used-date') }}</th>
                        <th>{{ translateKeyword('status') }}</th>
                        {{-- <th>{{ translateKeyword('used_count') }}</th> --}}
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>

    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

@endsection