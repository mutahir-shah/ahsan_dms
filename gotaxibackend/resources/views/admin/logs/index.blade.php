@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Activity Logs ')

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
                            <h3 class="card-title">{{ translateKeyword('Activity Logs')}}</h3>
                          
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="overflow: scroll;">
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th width="5%">{{ translateKeyword('id') }}</th>
                                    <th width="10%">{{ translateKeyword('module')}}</th>
                                    <th width="15%">{{ translateKeyword('Description')}}</th>
                                    <th width="50%">{{ translateKeyword('Payload')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($logs as $index => $log)
                                    <tr>
                                        <td>
                                            {{ $index + 1 }}
                                        </td>
                                        <td>{{ $log->module }}</td>
                                        <td>{{ $log->action }} <br/> 
                                            @isset($log->user)
                                            By {{ $log->user->name }} ({{ $log->user->role ? $log->user->role->name : '---' }}) <br/>
                                            {{ \Carbon\Carbon::parse($log->created_at)->format('F j, Y g:i A') }}   
                                            @endisset
                                        </td>
                                        <td>
                                            {{ json_encode($log->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width="5%">{{ translateKeyword('id') }}</th>
                                    <th width="10%">{{ translateKeyword('module')}}</th>
                                    <th width="15%">{{ translateKeyword('Description')}}</th>
                                    <th width="50%">{{ translateKeyword('Payload')}}</th>
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
                            Users
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
                            url: "{{ route('admin.user.mass-destroy') }}",
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
