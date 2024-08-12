@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Roles ')

@section('content')

    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card border-radius-10">
                        <div class="card-header">
                            @include('common.notify')
                            <h3 class="card-title">{{ translateKeyword('roles')}}</h3>
                            @if ($add_permission == 1)
                            <a href="{{ route('admin.role.create') }}" style="margin-left: 1em;"
                            class="btn btn-primary pull-right"><i class="fa fa-plus"></i> {{ translateKeyword('add-new-role')}}</a>
                            @endif
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="overflow: scroll;">
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('name')}}</th>
                                    <th>{{ translateKeyword('default')}}</th>
                                    <th>{{ translateKeyword('action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($roles as $i => $role)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->is_default ? 'Yes' : 'No' }}</td>
                                        <td>
                                            @if ($edit_permission == 1)
                                            <a href="{{ route('admin.role.edit', $role->id) }}"
                                                class="btn btn-info"><i class="fa fa-edit"></i> {{ translateKeyword('edit')}}</a>
                                            @endif
                                           @if (!$role->is_default)
                                                <form action="{{ route('admin.role.destroy', $role->id) }}" method="POST">
                                                @csrf 
                                                @method('DELETE')
                                                 @if ($delete_permission == 1)
                                                 <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure?')"><i
                                                        class="fa fa-trash"></i> {{ translateKeyword('delete')}}
                                                </button>
                                                 @endif
                                            </form>
                                           @endif
                                           @if ($edit_permission == 1)
                                           <a href="{{ route('admin.role.show', $role->id) }}"
                                                class="btn btn-info"><i class="fa fa-cog"></i> {{ translateKeyword('Role Permission Settings')}}</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('name')}}</th>
                                    <th>{{ translateKeyword('default')}}</th>
                                    <th>{{ translateKeyword('action')}}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
      


        <!-- DataTables -->
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    </div>
@endsection
