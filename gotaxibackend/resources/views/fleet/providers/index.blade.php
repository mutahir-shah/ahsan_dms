@extends('fleet.layout.basecode')
@extends('admin.layout.base2')
@section('title', 'Providers ')
@section('content')

    <link rel="stylesheet" href="{{url('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Providers</h3>
                            <a href="{{ route('fleet.provider.create') }}" style="margin-left: 1em;"
                               class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Provider</a>
                        </div>
                        <div class="card-body" style="overflow: scroll;">
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>Full Name</th>
                                    @if (Setting::get('partner_company_info') == 1)
                                        <th>Company Info.</th>
                                    @endif

                                    <th>Email</th>
                                    @if (Setting::get('address_user', 0) == 1)
                                    <th>Address</th>
                                    @endif
                                    @if (Setting::get('dob_user', 0) == 1)
                                        <th>DOB</th>
                                    @endif
                                    @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                                        <th>Zone</th>
                                    @endif
                                    <th>Fleet Owner</th>

                                    <th>Mobile</th>

                                    <th>Cancelled Requests</th>

                                    <th>Documents / Service Type</th>

                                    <th>Image</th>

                                    <th>Online</th>

                                    <th>Action</th>

                                </tr>

                                </thead>

                                <tbody>

                                @foreach($providers as $index => $provider)
                                    <tr>


                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $provider->first_name }} {{ $provider->last_name }}</td>
                                        @if (Setting::get('partner_company_info') == 1)
                                            <td>
                                                Name: {{ $provider->company_name ?: 'N/A' }}<br/>
                                                Address: {{ $provider->company_address ?: 'N/A' }}<br/>
                                                VAT: {{ $provider->company_vat ? : 'N/A' }}<br/>
                                            </td>
                                        @endif
                                        @if(Setting::get('demo_mode', 0) == 1)

                                            <td>{{ substr($provider->email, 0, 3).'****'.substr($provider->email, strpos($provider->email, "@")) }}</td>

                                        @else

                                            <td>{{ $provider->email }}</td>

                                        @endif
                                        @if (Setting::get('address_user', 0) == 1)
                                        <td>{{ $provider->address ?: 'N/A' }}</td>
                                        @endif
                                        @if (Setting::get('dob_user', 0) == 1)
                                            <td>{{ $provider->dob ?: 'N/A' }}</td>
                                        @endif
                                        @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                                            <td>{{ $provider->zone_id ?: 'N/A' }}</td>
                                        @endif
                                        <td>{{ $provider->fleetData ? $provider->fleetData->name : 'N/A' }}</td>

                                        @if(Setting::get('demo_mode', 0) == 1)

                                            <td>+919876543210</td>

                                        @else

                                            <td>{{ $provider->mobile }}</td>

                                        @endif


                                        <td>{{ $provider->total_requests - $provider->accepted_requests }}</td>

                                        <td>

                                            @if($provider->pending_documents() > 0 || $provider->service == null)

                                                <a class="btn btn-danger btn-block label-right"
                                                   href="{{route('fleet.provider.document.index', $provider->id )}}">Attention!
                                                    <span class="btn-label">{{ $provider->pending_documents() }}</span></a>

                                            @else

                                                <a class="btn btn-success btn-block"
                                                   href="{{route('fleet.provider.document.index', $provider->id )}}">All
                                                    Set!</a>

                                            @endif

                                        </td>

                                        <td>
                                            @if(isset($provider->avatar))
                                                <img style="height: 70px; margin-bottom: 15px; border-radius:2em;"
                                                     src=" {{  URL::to('/') }}/storage/{{$provider->avatar}}">
                                            @endif
                                        </td>

                                        <td>

                                            @if($provider->service->count() > 0)

                                                @if($provider->service[0]->status == 'active')

                                                    <label class="btn btn-block btn-primary">Yes</label>

                                                @else

                                                    <label class="btn btn-block btn-warning">No</label>

                                                @endif

                                            @else

                                                <label class="btn btn-block btn-danger">N/A</label>

                                            @endif

                                        </td>

                                        <td>

                                            <div class="input-group-btn">

                                                {{-- @if($provider->status == 'approved')

                                                    <a class="btn btn-danger btn-block"
                                                       href="{{ route('fleet.provider.disapprove', $provider->id ) }}">Disable</a>

                                                @else

                                                    <a class="btn btn-success btn-block"
                                                       href="{{ route('fleet.provider.approve', $provider->id ) }}">Enable</a>

                                                @endif --}}

                                                <button type="button"

                                                        class="btn btn-info btn-block dropdown-toggle"

                                                        data-toggle="dropdown">Action

                                                    <span class="caret"></span>

                                                </button>

                                                <ul class="dropdown-menu">

                                                    <li>

                                                        <a href="{{ route('fleet.provider.request', $provider->id) }}"
                                                           class="btn btn-default"><i class="fa fa-search"></i> History</a>

                                                    </li>

                                                    <li>

                                                        <a href="{{ route('fleet.provider.edit', $provider->id) }}"
                                                           class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>

                                                    </li>

                                                    <li>

                                                        <form action="{{ route('fleet.provider.destroy', $provider->id) }}"
                                                              method="POST">

                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="_method" value="DELETE">

                                                            <button class="btn btn-default look-a-like"
                                                                    onclick="return confirm('Are you sure?')"><i
                                                                        class="fa fa-trash"></i> Delete
                                                            </button>

                                                        </form>

                                                    </li>

                                                </ul>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                                </tbody>

                                <tfoot>

                                <tr>

                                    <th>ID</th>

                                    <th>Full Name</th>

                                    <th>Email</th>

                                    @if (Setting::get('address_user', 0) == 1)
                                    <th>Address</th>
                                    @endif
                                    @if (Setting::get('dob_user', 0) == 1)
                                        <th>DOB</th>
                                    @endif
                                    @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                                        <th>Zone</th>
                                    @endif

                                    <th>Fleet Owner</th>

                                    <th>Mobile</th>

                                    <th>Cancelled Requests</th>

                                    <th>Documents / Service Type</th>

                                    <th>Image</th>

                                    <th>Online</th>

                                    <th>Action</th>

                                </tr>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



    <script src="{{url('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
@endsection