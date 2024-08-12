@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Users ')

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
                            <h3 class="card-title">{{ translateKeyword('users') }}</h3>
                            @if ($add_permission == 1)
                                <a href="{{ route('admin.user.create') }}" style="margin-left: 1em;"
                                    class="btn btn-primary pull-right"><i class="fa fa-plus"></i>
                                    {{ translateKeyword('add_new_user') }}</a>
                            @endif
                            @if ($delete_permission == 1)
                                <button id="delete_record" style="margin-left: 1em;" class="btn btn-danger pull-right"><i
                                        class="fa fa-trash"></i> {{ translateKeyword('delete-selected') }}
                                </button>
                            @endif
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="overflow: scroll;">
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><input id="checkall" type="checkbox" onclick="selectall()" /></th>
                                        <th>{{ translateKeyword('id') }}</th>
                                        <th>{{ translateKeyword('first_name') }}</th>
                                        <th>{{ translateKeyword('last_name') }}</th>
                                        @if (Setting::get('email_field', 0) == 1)
                                            <th>{{ translateKeyword('email') }}</th>
                                        @endif
                                        @if (Setting::get('address_user', 0) == 1)
                                            <th>{{ translateKeyword('address') }}</th>
                                        @endif
                                        @if (Setting::get('dob_user', 0) == 1)
                                            <th>DOB</th>
                                        @endif
                                        @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                                            <th>{{ translateKeyword('Zones') }}</th>
                                        @endif
                                        <th>{{ translateKeyword('mobile') }}</th>
                                        <th>{{ translateKeyword('device-type') }}</th>
                                        <th>{{ translateKeyword('created') }}</th>
                                        <th>{{ translateKeyword('ratings') }}</th>
                                        @if (Setting::get('wallet', 0) == 1)
                                            <th>{{ translateKeyword('Wallet_Amount') }}</th>
                                        @endif
                                        @if (Setting::get('reward_point_customer', 0) == 1)
                                            <th>{{ translateKeyword('reward-points') }}</th>
                                        @endif
                                        @if (Setting::get('user_referral', 0) == 1)
                                            <th>{{ translateKeyword('user-referrals') }}</th>
                                            <th>{{ translateKeyword('driver-referrals') }}</th>
                                        @endif
                                        <th>{{ translateKeyword('action') }}</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td><input type="checkbox" name="user[]" value="{{ $user->id }}"
                                                    class="delete_check" onclick="checkcheckbox()" /></td>
                                            <td>
                                                {{ $index + 1 }}
                                            </td>
                                            <td>{{ $user->first_name }}</td>
                                            <td>{{ $user->last_name }}</td>
                                            @if (Setting::get('email_field', 0) == 1)
                                                @if (Setting::get('demo_mode', 0) == 1)
                                                    <td>{{ substr($user->email, 0, 3) . '****' . substr($user->email, strpos($user->email, '@')) }}
                                                    </td>
                                                @else
                                                    <td>{{ $user->email ?: 'N/A' }}</td>
                                                @endif
                                            @endif
                                            @if (Setting::get('address_user', 0) == 1)
                                                <td>{{ $user->address ?: 'N/A' }}</td>
                                            @endif
                                            @if (Setting::get('dob_user', 0) == 1)
                                                <td>{{ $user->dob ?: 'N/A' }}</td>
                                            @endif
                                            @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                                                <td>{{ $user->zone_id ?: 'N/A' }}</td>
                                            @endif
                                            @if (Setting::get('demo_mode', 0) == 1)
                                                <td>+92*********</td>
                                            @else
                                                <td>{{ $user->mobile ?: 'N/A' }}</td>
                                            @endif
                                            <td>{{ $user->device_type }}</td>
                                            <td>{{ $user->created_at->toDayDateTimeString() }}</td>
                                            <td>{{ $user->rating }}</td>
                                            @if (Setting::get('wallet', 0) == 1)
                                                <td>{{ currency($user->wallet_balance) }}</td>
                                            @endif
                                            @if (Setting::get('reward_point_customer', 0) == 1)
                                                <td>{{ $user->reward_points }}</td>
                                            @endif
                                            @if (Setting::get('user_referral', 0) == 1)
                                                <td>
                                                    {{ $user->user_referral_count }} <br /> <a
                                                        href="{{ route('admin.user.reset-user-referral', [$user->id]) }}"
                                                        class="btn btn-info" data-toggle="tooltip"
                                                        title="Reset User Referral Count!"><i class="fa fa-refresh"></i></a>
                                                </td>
                                                <td>
                                                    {{ $user->provider_referral_count }} <br /> <a
                                                        href="{{ route('admin.user.reset-driver-referral', [$user->id]) }}"
                                                        class="btn btn-info" data-toggle="tooltip"
                                                        title="Reset Driver Referral Count!"><i
                                                            class="fa fa-refresh"></i></a>
                                                </td>
                                            @endif
                                            <td>
                                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @if ($edit_permission == 1)
                                                        @if ($user->status == 'approved')
                                                            <a class="btn btn-danger"
                                                                href="{{ route('admin.user.disable', $user->id) }}">Disable</a>
                                                        @else
                                                            <a class="btn btn-success"
                                                                href="{{ route('admin.user.enable', $user->id) }}">Enable</a>
                                                        @endif
                                                        <a href="{{ route('admin.user.edit', $user->id) }}"
                                                            class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
                                                    @endif

                                                    @if ($view_permission == 1)
                                                        <a href="{{ route('admin.user.request', $user->id) }}"
                                                            class="btn btn-info"><i class="fa fa-search"></i> History</a>
                                                    @endif

                                                    @if (Setting::get('user_verification', 0) == 1)
                                                        <a href="{{ route('admin.user_documents.index', $user->id) }}"
                                                            class="btn btn-info"><i class="fa fa-document"></i>
                                                            Documents</a>
                                                    @endif

                                                    @if ($notify_permission == 1)
                                                        <a href="{{ route('admin.push.user', $user->id) }}"
                                                            class="btn btn-info"><i class="fa fa-bell"></i> Notify</a>
                                                    @endif

                                                    @if ($delete_permission == 1)
                                                        <button class="btn btn-danger"
                                                            onclick="return confirm('Are you sure?')"><i
                                                                class="fa fa-trash"></i> Delete
                                                        </button>
                                                    @endif

                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th><input id="checkall" type="checkbox" onclick="selectall()" /></th>
                                        <th>{{ translateKeyword('id') }}</th>
                                        <th>{{ translateKeyword('first_name') }}</th>
                                        <th>{{ translateKeyword('last_name') }}</th>
                                        @if (Setting::get('email_field', 0) == 1)
                                            <th>{{ translateKeyword('email') }}</th>
                                        @endif
                                        @if (Setting::get('address_user', 0) == 1)
                                            <th>{{ translateKeyword('address') }}</th>
                                        @endif
                                        @if (Setting::get('dob_user', 0) == 1)
                                            <th>DOB</th>
                                        @endif
                                        @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                                            <th>{{ translateKeyword('Zones') }}</th>
                                        @endif
                                        <th>{{ translateKeyword('mobile') }}</th>
                                        <th>{{ translateKeyword('device-type') }}</th>
                                        <th>{{ translateKeyword('created') }}</th>
                                        <th>{{ translateKeyword('ratings') }}</th>
                                        @if (Setting::get('wallet', 0) == 1)
                                            <th>{{ translateKeyword('Wallet_Amount') }}</th>
                                        @endif
                                        @if (Setting::get('reward_point_customer', 0) == 1)
                                            <th>{{ translateKeyword('reward-points') }}</th>
                                        @endif
                                        @if (Setting::get('user_referral', 0) == 1)
                                            <th>{{ translateKeyword('user-referrals') }}</th>
                                            <th>{{ translateKeyword('driver-referrals') }}</th>
                                        @endif
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
            $('#checkall').click(function() {
                if ($(this).is(':checked')) {
                    $('.delete_check').prop('checked', true);
                } else {
                    $('.delete_check').prop('checked', false);
                }
            });

            // Delete record
            $('#delete_record').click(function() {

                var deleteids_arr = [];
                // Read all checked checkboxes
                $("input:checkbox[class=delete_check]:checked").each(function() {
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
                            success: function(response) {
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
                $('.delete_check').each(function() {
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
