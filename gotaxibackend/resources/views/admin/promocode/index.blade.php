@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Promocodes ')

@section('content')

    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card border-radius-10">
                        <div class="card-header">
                            <h5 class="mb-1">{{ translateKeyword('promocodes') }}</h5>
                            @if ($add_permission == 1)
                            <a href="{{ route('admin.promocode.create') }}" style="margin-left: 1em;"
                            class="btn btn-primary pull-right"><i class="fa fa-plus"></i> {{ translateKeyword('add_new_promocode') }}</a>
                            @endif
                            
                        </div>
                        <div class="card-body" style="overflow: scroll;">
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('promocode')}}</th>
                                    <th>{{ translateKeyword('discount') }}</th>
                                    <th>{{ translateKeyword('expiration')}}</th>
                                    <th>{{ translateKeyword('Status') }}</th>
                                    <th>{{ translateKeyword('max-uses(one-per-user)') }}</th>
                                    <th>{{ translateKeyword('used_count') }}</th>
                                    <th>{{ translateKeyword('action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($promocodes as $index => $promo)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$promo->promo_code}}</td>
                                        <td>{{$promo->discount}}</td>
                                        <td>
                                            {{date('d-m-Y',strtotime($promo->expiration))}}
                                        </td>
                                        <td>
                                            @if(date("Y-m-d") <= $promo->expiration)
                                                <span class="tag tag-success">{{ translateKeyword('valid')}}</span>
                                            @else
                                                <span class="tag tag-danger">{{ translateKeyword('expiration') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{$promo->max_count}}
                                        </td>
                                        <td>
                                            {{promo_used_count($promo->id)}}
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.promocode.destroy', $promo->id) }}"
                                                  method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                                @if ($edit_permission == 1)
                                                <a href="{{ route('admin.promocode.edit', $promo->id) }}"
                                                    class="btn btn-info"><i class="fa fa-edit"></i> {{ translateKeyword('edit') }}</a>
                                                @endif
                                                @if ($delete_permission == 1)
                                                <button class="btn btn-danger"
                                                        onclick="return confirm('Are you sure?')"><i
                                                            class="fa fa-trash"></i> {{ translateKeyword('delete') }}
                                                </button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('promocode')}}</th>
                                    <th>{{ translateKeyword('discount') }}</th>
                                    <th>{{ translateKeyword('expiration')}}</th>
                                    <th>{{ translateKeyword('Status') }}</th>
                                    <th>{{ translateKeyword('max-uses(one-per-user)') }}</th>
                                    <th>{{ translateKeyword('used_count') }}</th>
                                    <th>{{ translateKeyword('action') }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
@endsection