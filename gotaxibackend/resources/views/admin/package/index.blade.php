@extends('admin.layout.base')


@section('title', 'Service Packages')



@section('content')

    <div class="content-area py-1">

        <div class="container-fluid">

            <div class="box box-block bg-white">

                <h5 class="mb-1">{{ translateKeyword('service-packages')}}</h5>

                <a href="{{ route('admin.package.create') }}" style="margin-left: 1em;"
                   class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Package</a>

                <table class="table table-striped table-bordered dataTable" id="table-2">

                    <thead>

                    <tr>

                        <th>ID</th>

                        <th>Package Name</th>

                        <th>Fixed Time</th>

                        <th>Fixed Distance</th>

                        <th>Fixed Price</th>

                        <th>Per Hour Price</th>

                        <th>Per @if (Setting::get('distance_system') === 'metric')
                                KM
                            @else
                                Miles
                            @endif Price
                        </th>

                        <th>Action</th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($packages as $index => $package)

                        <tr>

                            <td>{{ $index + 1 }}</td>

                            <td>{{ $package->name }}</td>

                            <td>{{ $package->base_time }}</td>

                            <td>{{ $package->base_distance }}</td>

                            <td>{{ currency($package->base_price) }}</td>

                            <td>{{ currency( $package->after_time_price) }}</td>

                            <td>{{ currency( $package->after_distance_price) }}</td>

                            <td>

                                <form action="{{ route('admin.package.destroy', $package->id) }}" method="POST">

                                    {{ csrf_field() }}

                                    {{ method_field('DELETE') }}
                                    <a href="{{ route('admin.package.edit', $package->id) }}"
                                       class="btn btn-info btn-block">

                                        <i class="fa fa-pencil"></i> Edit

                                    </a>

                                    <button class="btn btn-danger btn-block" onclick="return confirm('Are you sure?')">

                                        <i class="fa fa-trash"></i> Delete

                                    </button>

                                </form>

                            </td>


                        </tr>

                    @endforeach

                    </tbody>

                    <tfoot>

                    <tr>
                        <th>ID</th>

                        <th>Package Name</th>

                        <th>Fixed Time</th>

                        <th>Fixed Distance</th>

                        <th>Fixed Price</th>

                        <th>Per Hour Price</th>

                        <th>Per @if (Setting::get('distance_system') === 'metric')
                                KM
                            @else
                                Miles
                            @endif Price
                        </th>

                        <th>Action</th>

                    </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>

@endsection