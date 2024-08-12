@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Admins ')

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
                            <h3 class="card-title">{{ translateKeyword('admins') }}</h3>
                            @if ($add_permission == 1)
                            <a href="{{ route('admin.admin.create') }}" style="margin-left: 1em;"
                            class="btn btn-primary pull-right"><i class="fa fa-plus"></i> {{ translateKeyword('add-new-admin')}}</a>
                            @endif
                            
                            @if ($delete_permission == 1)
                            <button id="delete_record" style="margin-left: 1em;" class="btn btn-danger pull-right"><i
                                class="fa fa-trash"></i> {{ translateKeyword('delete-selected')}}
                            </button>
                            @endif
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="overflow: scroll;">
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th><input id="checkall" type="checkbox" onclick="selectall()"/></th>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('name') }}</th>
                                    <th>{{ translateKeyword('email') }}</th>
                                    <th>{{translateKeyword('role-new') }}</th>
                                    <th>{{ translateKeyword('action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($admins as $index => $admin)
                                    <tr>
                                        <td><input type="checkbox" name="user[]" value="{{ $admin->id }}"
                                                   class="delete_check" onclick="checkcheckbox()"/></td>
                                        <td>
                                            {{ $index + 1 }}
                                        </td>
                                        <td>{{ $admin->name }}</td>
                                        @if (Setting::get('demo_mode', 0) == 1)
                                            <td>{{ substr($admin->email, 0, 3) . '****' . substr($admin->email, strpos($admin->email, '@')) }}
                                            </td>
                                        @else
                                            <td>{{ $admin->email }}</td>
                                        @endif
                                        <td>{{ $admin->role->name }}</td>
                                        <td>
                                            <form action="{{ route('admin.admin.destroy', $admin->id) }}" method="POST">
                                                @if ($status_permission == 1)
                                                    @if ($admin->status == 1)
                                                        <a class="btn btn-danger"
                                                            href="{{ route('admin.admin.disapprove', $admin->id) }}">{{ translateKeyword('Disable') }}</a>
                                                    @else
                                                        <a class="btn btn-success"
                                                            href="{{ route('admin.admin.approve', $admin->id) }}">{{ translateKeyword('Enable') }}</a>
                                                    @endif
                                                @endif
                                               
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                                @if ($edit_permission == 1)
                                                    <a href="{{ route('admin.admin.edit', $admin->id) }}"
                                                    class="btn btn-info"><i class="fa fa-edit"></i> {{ translateKeyword('edit') }}</a>
                                                @endif
                                                
                                                @if ($delete_permission == 1)
                                                    <button class="btn btn-danger"
                                                            onclick="return confirm('Are you sure?')"><i
                                                                class="fa fa-trash"></i> {{ translatekeyword('delete')}}
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('name') }}</th>
                                    <th>{{ translateKeyword('email') }}</th>
                                    <th>{{translateKeyword('role-new') }}</th>
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
        <!-- <div class="container-fluid">
                    <div class="box card-body">
                        <h5 class="mb-1">
                            Admins
                            @if (Setting::get('demo_mode', 0) == 1)
            <span class="pull-right">(*personal information hidden in demo)</span>

        @endif
        </h5>

        <table class="table table-striped table-bordered dataTable" id="example-1">

        </table>
    </div>
</div> -->


        <!-- DataTables -->
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script type="text/javascript">
            // Check all
            $('#checkall').click(function () {
                if ($(this).is(':checked')) {
                    $('.delete_check').prop('checked', true);
                } else {
                    $('.delete_check').prop('checked', false);
                }
            });

            // Delete record
            $('#delete_record').click(function () {

                var deleteids_arr = [];
                // Read all checked checkboxes
                $("input:checkbox[class=delete_check]:checked").each(function () {
                    deleteids_arr.push($(this).val());
                });

                // Check checkbox checked or not
                if (deleteids_arr.length > 0) {
                    // Confirm alert
                    var confirmdelete = confirm("Do you really want to delete records?");
                    var token = $('#token').val();
                    if (confirmdelete == true) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': window.Laravel.csrfToken
                            },
                            url: "{{ route('admin.admin.mass-destroy') }}",
                            type: 'post',
                            data: {
                                deleteids_arr: deleteids_arr
                            },
                            success: function (response) {
                                location.reload();
                            }
                        });
                    }
                }
            });

            // Checkbox checked
            function checkcheckbox() {
                // Total checkboxes
                var length = $('.delete_check').length;
                // Total checked checkboxes
                var totalchecked = 0;
                $('.delete_check').each(function () {
                    if ($(this).is(':checked')) {
                        totalchecked += 1;
                    }
                });

                // Checked unchecked checkbox
                if (totalchecked == length) {
                    $("#checkall").prop('checked', true);
                } else {
                    $('#checkall').prop('checked', false);
                }
            }
        </script>
    </div>
@endsection
