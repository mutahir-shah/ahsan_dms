@extends('admin.layout.base')

@section('title', 'Service Package ')

@section('content')
    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <h5 class="mb-1">{{ translateKeyword('package-to-service-type-allocation') }}</h5>
                <div class="row">
                    <div class="col-xs-12">

                        <hr>
                        <h6>Allocated Package : </h6>
                        <table class="table table-striped table-bordered dataTable">
                            <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($PackageService as $package)
                                <tr>
                                    <td>{{ $package->service_type->name }}</td>

                                    <td>
                                        <form action="{{ route('admin.package.document.service', [$package->package_id, $package->service_type_id]) }}"
                                              method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger btn-large btn-block">Delete</a>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Service Name</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>

                        <hr>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection