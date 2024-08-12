@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', '')

@section('content')

    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card border-radius-10">
                        <div class="card-header">
                            <h5 class="mb-1">{{ translateKeyword('Provider Subscriptions')}}</h5>
                            @if ($add_permission == 1)
                            <a href="{{ route('admin.subscription-provider.create') }}" style="margin-left: 1em;"
                            class="btn btn-primary pull-right"><i class="fa fa-plus"></i> {{ translateKeyword('add-new-subscription')}}</a>
                            @endif
                        </div>
                        <div class="card-body" style="overflow: scroll;">
                            @include('common.notify')
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('package-name')}}</th>
                                    <th>{{ translateKeyword('amount')}}</th>
                                    {{-- <th>Trial Period</th> --}}
                                    <th>{{ translateKeyword('interval-period(Days)')}}</th>
                                    <th>{{ translateKeyword('rides-new')}}</th>
                                    <th>{{ translateKeyword('action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subscriptions as $index => $subscription)
                                @php
                                    $title = $subscription->translations->where('language_id', session('translation'))->first()->name ?? $subscription->title;
                                @endphp
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$title}}</td>
                                        <td>{{currency($subscription->value)}}</td>
                                        {{-- <td>{{$subscription->trial_period}}</td> --}}
                                        <td>{{$subscription->days}}</td>
                                        <td>{{$subscription->rides}}</td>
                                        <td>
                                            @if ($edit_permission == 1)     
                                            <a href="{{ route('admin.subscription-provider.edit', $subscription->id) }}"
                                                class="btn btn-info"><i class="fa fa-edit"></i> {{ translateKeyword('edit')}}</a>
                                            @endif
                                                <form action="{{ route('admin.subscription-provider.destroy', $subscription->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @if ($delete_permission == 1)
                                                    
                                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> {{ translateKeyword('delete')}}</button>
                                                    @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('package-name')}}</th>
                                    <th>{{ translateKeyword('amount')}}</th>
                                    {{-- <th>Trial Period</th> --}}
                                    <th>{{ translateKeyword('interval-period(Days)')}}</th>
                                    <th>{{ translateKeyword('rides-new')}}</th>
                                    <th>{{ translateKeyword('action')}}</th>
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