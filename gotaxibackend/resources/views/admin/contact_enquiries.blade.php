@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Contact Enquires ')

@section('content')
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="box box-block bg-white border-radius-10">
                <h5 class="mb-1">{{ translateKeyword('contact-enquires') }} </h5>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                        <tr>
                            <th>{{ translateKeyword('contact-enquires') }}</th>
                            <th>{{ translateKeyword('name') }}</th>
                            <th>{{ translateKeyword('email') }}</th>
                            <th>{{ translateKeyword('subject') }}</th>
                            <th>{{ translateKeyword('content') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contactEnquiries as $index => $contactEnquiry)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $contactEnquiry->name }}</td>
                                <td>{{ $contactEnquiry->email }}</td>
                                <td>{{ $contactEnquiry->subject }}</td>
                                <td>{{ $contactEnquiry->content }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ translateKeyword('contact-enquires') }}</th>
                            <th>{{ translateKeyword('name') }}</th>
                            <th>{{ translateKeyword('email') }}</th>
                            <th>{{ translateKeyword('subject') }}</th>
                            <th>{{ translateKeyword('content') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>

    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
@endsection
