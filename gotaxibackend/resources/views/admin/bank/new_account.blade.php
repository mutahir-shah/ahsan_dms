@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Bank')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <h5 class="mb-1"><span class="s-icon"><i class="ti-stats-up"></i></span> &nbsp;{{ translateKeyword('new-request') }}</h5>
                <hr/>
                <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                    <thead>
                    <tr>
                        <th>{{ translateKeyword('id') }}</th>
                        <th>{{ translateKeyword('account-holder-name') }}</th>
                        <th>{{ translateKeyword('bank-name') }}</th>
                        <th>{{ translateKeyword('account-number') }}</th>
                        <th>{{ translateKeyword('type') }}</th>
                        <th>{{ translateKeyword('status') }}</th>
                        <th>{{ translateKeyword('action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bank as $index => $service)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $service->account_name }}</td>
                            <td>{{ $service->bank_name }}</td>
                            <td>{{ $service->account_number }}</td>
                            <td>{{ $service->type }}</td>
                            <td>{{ $service->status }}</td>
                            <td>
                                {{ csrf_field() }}
                                <a href="{{ route('admin.bank.approve', $service->id ) }}"
                                   class="btn shadow-box btn-success btn-rounded w-min-sm m-b-0-25 waves-effect waves-light"
                                   id="accountApproved" data="{{ $service->id }}">
                                    {{ translateKeyword('Approved')}}
                                </a>
                                <!-- </form> -->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection