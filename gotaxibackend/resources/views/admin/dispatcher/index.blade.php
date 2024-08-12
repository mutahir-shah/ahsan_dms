@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Dispatcher ')

@section('content')

    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-1">
                                {{ translateKeyword('dispatcher')}}
                                @if(Setting::get('demo_mode', 0) == 1)
                                    <span class="pull-right">(*personal information hidden in demo)</span>
                                @endif
                            </h5>
                            <a href="{{ route('admin.dispatch-manager.create') }}" style="margin-left: 1em;"
                               class="btn btn-primary pull-right"><i class="fa fa-plus"></i> {{ translateKeyword('add_new_dispatcher') }}</a>
                        </div>
                        <div class="card-body" style="overflow: scroll;">
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('full_name') }}</th>
                                    <th>{{ translateKeyword('email') }}</th>
                                    <th>{{ translateKeyword('mobile') }}</th>
                                    <th>{{ translateKeyword('action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dispatchers as $index => $dispatcher)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $dispatcher->name }}</td>
                                        @if(Setting::get('demo_mode', 0) == 1)
                                            <td>{{ substr($dispatcher->email, 0, 3).'****'.substr($dispatcher->email, strpos($dispatcher->email, "@")) }}</td>
                                        @else
                                            <td>{{ $dispatcher->email }}</td>
                                        @endif
                                        @if(Setting::get('demo_mode', 0) == 1)
                                            <td>+919876543210</td>
                                        @else
                                            <td>{{ $dispatcher->mobile }}</td>
                                        @endif
                                        <td>
                                            <form action="{{ route('admin.dispatch-manager.destroy', $dispatcher->id) }}"
                                                  method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ route('admin.dispatch-manager.edit', $dispatcher->id) }}"
                                                   class="btn btn-info"><i class="fa fa-edit"></i> {{ translateKeyword('edit') }}</a>
                                                <button class="btn btn-danger"
                                                        onclick="return confirm('Are you sure?')"><i
                                                            class="fa fa-trash"></i> {{ translateKeyword('delete')}}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('full_name') }}</th>
                                    <th>{{ translateKeyword('email') }}</th>
                                    <th>{{ translateKeyword('mobile') }}</th>
                                    <th>{{ translateKeyword('action') }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

@endsection