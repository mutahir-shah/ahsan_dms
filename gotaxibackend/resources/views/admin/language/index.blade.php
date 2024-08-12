@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Languages ')

@section('content')

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card border-radius-10">
                        <div class="card-header">
                            @include('common.notify')
                            <h3 class="card-title">{{ translateKeyword('languages') }}</h3>
                            {{-- <a href="{{ route('admin.language.create') }}"
                                class="btn btn-primary pull-right">{{ translateKeyword('create-new') }}</a> --}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="overflow: scroll;">
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ translateKeyword('id') }}</th>
                                        <th>{{ translateKeyword('name') }}</th>
                                        <th>{{ translateKeyword('short-name') }}</th>
                                        <th>{{ translateKeyword('is-default') }}</th>
                                        <th>{{ translateKeyword('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($languages as $i => $language)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $language->name }}</td>
                                            <td>{{ $language->short_name }}</td>
                                            <td>
                                                @if ($language->is_default == 1)
                                                    {{ translateKeyword('yes') }}
                                                @else
                                                    {{ translateKeyword('no') }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.language.manage-translation', $language->id) }}"
                                                    class="btn btn-sm btn-primary">{{ translateKeyword('manage_translation') }}</a>
                                                {{-- <a href="{{ route('admin.language.edit', $language->id) }}"
                                                    class="btn btn-sm btn-primary">{{ translateKeyword('edit') }}</a> --}}
                                                @if ($language->is_default != 1)
                                                    @if ($language->status == 'Active')
                                                    <a href="{{ route('admin.language.change-status', $language->id) }}"
                                                        class="btn btn-sm btn-danger">{{ translateKeyword('Disable') }}</a>
                                                    @else
                                                        <a href="{{ route('admin.language.change-status', $language->id) }}"
                                                            class="btn btn-sm btn-success">{{ translateKeyword('Enable') }}</a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{ translateKeyword('id') }}</th>
                                        <th>{{ translateKeyword('name') }}</th>
                                        <th>{{ translateKeyword('is-default') }}</th>
                                        <th>{{ translateKeyword('action') }}</th>
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
        <script src="{{ asset('admin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('admin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{ asset('admin') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{ asset('admin') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    </div>
@endsection
