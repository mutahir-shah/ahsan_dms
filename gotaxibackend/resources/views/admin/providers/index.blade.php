@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Providers ')
@section('content')

    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card border-radius-10">
                        <div class="card-header">
                            @include('common.notify')
                            <h3 class="card-title">{{ translateKeyword('providers') }}</h3>

                            @if($add_permission == 1)    
                            <a href="{{ route('admin.provider.create') }}" style="margin-left: 1em;"
                            class="btn btn-primary pull-right"><i class="fa fa-plus"></i> {{ translateKeyword('add_new_provider') }}</a>
                            @endif
                            
                            @if($status_permission == 1)    
                            <a href="{{ url('/admin/changestatusallonline') }}" style="margin-left: 1em;"
                            class="btn btn-primary pull-right"> {{ translateKeyword('turn-all-online') }}</a>
                            <a href="{{ url('/admin/changestatusalloffline') }}" style="margin-left: 1em;"
                            class="btn btn-danger pull-right"> {{ translateKeyword('turn-all-offline') }}</a>
                            @endif
                           
                            @if($delete_permission == 1)    
                               <button id="delete_record" style="margin-left: 1em;" class="btn btn-danger pull-right"><i
                                        class="fa fa-trash"></i> {{ translateKeyword('delete-selected') }}
                            </button>
                            @endif

                            <a href="{{ URL::previous() }}" style="margin-left: 1em;"
                               class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>

                        </div>
                        <div class="card-body" style="overflow: scroll;">
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>

                                <tr>
                                    <th><input id="checkall" type="checkbox" onclick="selectall()"/></th>
                                    <th>{{ translateKeyword('id') }}</th>

                                    <th>{{ translateKeyword('full_name') }}</th>
                                    @if (Setting::get('partner_company_info') == 1)
                                        <th>{{translateKeyword('company-info')}}.</th>
                                    @endif
                                    <th>{{ translateKeyword('mobile') }}</th>
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
                                    <th>{{ translateKeyword('fleet_owner') }}</th>

                                    <th>{{ translateKeyword('device') }}</th>
                                    <th>{{ translateKeyword('reg-date') }}</th>
                                    @if (Setting::get('subscription_module', '') == 1)
                                        <th>{{translateKeyword('subscription')}}</th>
                                        <th>{{ translateKeyword('auto-subscription') }}</th>
                                    @endif
                                    @if (Setting::get('wallet', 0) == 1)
                                    <th>{{ translateKeyword('wallet') }}</th>
                                    @endif
                                    <th>{{ translateKeyword('cancelled_requests') }}</th>
                                    <th>{{ translateKeyword('Rating') }}</th>
                                    @if (Setting::get('driver_referral', 0) == 1)
                                    <th>{{ translateKeyword('user-referrals') }}</th>
                                    <th>{{ translateKeyword('driver-referrals') }}</th>
                                    @endif

                                    @if ($edit_permission == 1)
                                        <th>{{ translateKeyword('service_type') }}</th>
                                    @endif

                                    @if (Setting::get('driver_pic_mandatory', 0) == 1)
                                    
                                    <th>{{ translateKeyword('image') }}</th>
                                    @endif

                                    <th>{{ translateKeyword('action') }}</th>

                                </tr>

                                </thead>

                                <tbody>

                                @foreach ($providers as $index => $provider)
                                    <tr>
                                        <td><input type="checkbox" name="provider[]" value="{{ $provider->id }}"
                                                   class="delete_check" onclick="checkcheckbox()"/></td>

                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $provider->first_name }} {{ $provider->last_name }}</td>
                                        @if (Setting::get('partner_company_info') == 1)
                                            <td>
                                                {{ translateKeyword('name')}}: {{ $provider->company_name ?: 'N/A' }}<br/>
                                                {{translateKeyword('address')}}: {{ $provider->company_address ?: 'N/A' }}<br/>
                                                VAT: {{ $provider->company_vat ? : 'N/A' }}<br/>
                                            </td>
                                        @endif

                                        @if (Setting::get('demo_mode', 0) == 1)
                                            <td>+92*********</td>
                                        @else
                                            <td>{{ $provider->mobile ?: 'N/A' }}</td>
                                        @endif
                                        @if (Setting::get('email_field', 0) == 1)
                                            @if (Setting::get('demo_mode', 0) == 1)
                                                <td>N/A</td>
                                            @else
                                                <td>{{ $provider->email ?: 'N/A' }}</td>
                                            @endif
                                        @endif
                                        @if (Setting::get('address_user', 0) == 1)
                                            <td>{{ $provider->address ?: 'N/A' }}</td>
                                        @endif
                                        @if (Setting::get('dob_user', 0) == 1)
                                            <td>{{ $provider->dob ?: 'N/A' }}</td>
                                        @endif
                                        @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                                            <td>{{ $provider->zone ? $provider->zone->name : 'N/A' }}</td>
                                        @endif
                                        <td>{{ $provider->fleetData ? $provider->fleetData->name : 'N/A' }}</td>

                                        <td>{{ $provider->device ? $provider->device->type : 'N/A' }}</td>
                                        <td>{{ $provider->created_at->toDayDateTimeString() }}</td>

                                        @if (Setting::get('subscription_module', '') == 1)
                                            <td>{{ $provider->subscription ? $provider->subscription->title : 'N/A' }}
                                            </td>
                                            <td>{{ $provider->subscription ? 'Yes' : 'No' }}</td>
                                        @endif
                                        @if (Setting::get('wallet', 0) == 1)
                                        <td>{{ currency($provider->wallet) }}</td>
                                        @endif
                                        <td>{{ $provider->total_requests - $provider->accepted_requests }}</td>
                                        <td>{{ $provider->rating }}</td>
                                        @if (Setting::get('driver_referral', 0) == 1)
                                            <td>
                                                {{ $provider->user_referral_count }} <br/> <a href="{{ route('admin.user.reset-user-referral', [$provider->id]) }}" class="btn btn-info" data-toggle="tooltip" title="Reset User Referral Count!"><i class="fa fa-refresh"></i></a>
                                            </td>
                                            <td>
                                               {{ $provider->provider_referral_count }} <br/> <a href="{{ route('admin.user.reset-driver-referral', [$provider->id]) }}" class="btn btn-info" data-toggle="tooltip" title="Reset Driver Referral Count!"><i class="fa fa-refresh"></i></a>
                                            </td>
                                        @endif

                                        @if($edit_permission == 1)
                                            <td>
                                                @if ($driverDocsCount > $provider->documents_count())
                                                    <a class="btn btn-danger btn-block label-right"
                                                    href="{{ route('admin.provider.document.index', $provider->id) }}">{{ translateKeyword('attention!-pending-documents')}}
                                                        <span
                                                                class="btn-label">{{ ($driverDocsCount - $provider->documents_count()) }}</span></a>
                                                @elseif ($provider->pending_documents() > 0)
                                                    <a class="btn btn-danger btn-block label-right"
                                                        href="{{ route('admin.provider.document.index', $provider->id) }}">{{ translateKeyword('attention!-pending-documents-approval')}}
                                                        <span
                                                            class="btn-label">{{ ($provider->pending_documents()) }}</span></a>
                                                @elseif ($provider->service == null)
                                                    <a class="btn btn-danger btn-block label-right"
                                                    href="{{ route('admin.provider.document.index', $provider->id) }}">{{ translateKeyword('attention!-pending-service-creation')}}
                                                    </a>
                                                @elseif($driverVehiclesDocsCount > $provider->vehicle_documents_count())
                                                    <a class="btn btn-danger btn-block label-right"
                                                    href="{{ route('admin.provider.document.index', $provider->id) }}">{{ translateKeyword('attention!-missing-driver-vehicle-documents')}}
                                                        <span
                                                                class="btn-label">{{ ($driverVehiclesDocsCount - $provider->vehicle_documents_count()) }}</span></a>
                                                @elseif ($provider->vehicle_pending_documents() > 0)
                                                    <a class="btn btn-danger btn-block label-right"
                                                        href="{{ route('admin.provider.document.index', $provider->id) }}">{{ translateKeyword('attention!-Pending-Vehicle-Documents-Approval')}}
                                                        <span
                                                            class="btn-label">{{ ($provider->vehicle_pending_documents()) }}</span></a>
                                                @else
                                                    <a class="btn btn-success btn-block"
                                                    href="{{ route('admin.provider.document.index', $provider->id) }}">{{ translateKeyword('all-set!')}}</a>
                                                @endif

                                            </td>
                                        @endif
                                        @if (Setting::get('driver_pic_mandatory', 0) == 1)
                                        <td>
                                            @if (isset($provider->avatar))
                                                <img style="height: 50px; width:50px; border-radius:2em;"
                                                     src=" {{ URL::to('/') }}/storage/{{ $provider->avatar }}">
                                            @endif
                                        </td>
                                        @endif

                                        <td>

                                            <div class="input-group-btn">
                                                @if($status_permission == 1)    
                                                    @if ($provider->status == 'approved')
                                                        <a class="btn btn-danger btn-block"
                                                        href="{{ route('admin.provider.disapprove', $provider->id) }}">{{ translateKeyword('Disable')}}</a>
                                                    @else
                                                        <a class="btn btn-success btn-block"
                                                        href="{{ route('admin.provider.approve', $provider->id) }}">{{ translateKeyword('Enable') }}</a>
                                                    @endif
                                                @endif

                                                @if($view_permission == 1)    
                                                <a href="{{ route('admin.provider.request', $provider->id) }}"
                                                    class="btn btn-warning btn-block"><i class="fa fa-search"></i>
                                                    {{ translateKeyword('my_trips')}}</a>
                                                @endif
                                                
                                                @if($view_permission == 1)    
                                                <a href="{{ route('admin.provider.statement', $provider->id) }}"
                                                    class="btn btn-info btn-block"><i class="fa fa-account"></i>
                                                    {{ translateKeyword('Statements')}}</a>
                                                @endif
                                                    
                                                    
                                                @if($edit_permission == 1)    
                                                <a href="{{ route('admin.provider.edit', $provider->id) }}"
                                                    class="btn btn-dark btn-block mb-1"><i class="fa fa-edit"></i>
                                                    {{ translateKeyword('edit')}}</a>
                                                @endif 
                                                    
                                                @if($notify_permission == 1)    
                                                <a href="{{ route('admin.push.provider', $provider->id) }}"
                                                   class="btn btn-default btn-block look-a-like"><i
                                                            class="fa fa-bell"></i> Notify</a>
                                                @endif

                                                @if($delete_permission == 1)    
                                                <form
                                                        action="{{ route('admin.provider.destroy', $provider->id) }}"
                                                        method="POST">

                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="_method" value="DELETE">

                                                    <button class="btn btn-danger btn-block mt-2 look-a-like"
                                                            onclick="return confirm('Are you sure?')"><i
                                                                class="fa fa-trash"></i> {{ translateKeyword('delete')}}
                                                    </button>

                                                </form>
                                                @endif


                                            </div>

                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
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
                        url: "{{ route('admin.provider.mass-destroy') }}",
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

@endsection
