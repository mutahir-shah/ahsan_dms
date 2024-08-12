@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Documents ')

@section('content')

    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="box box-block">
                <h5 class="mb-1">{{ translateKeyword('documents') }}</h5>
                @include('common.notify')
                @if ($add_permission == 1)
                <a href="{{ route('admin.document.create') }}" style="margin-left: 1em;"
                class="btn btn-primary pull-right color-white"><i class="fa fa-plus"></i> {{ translateKeyword('add_new_document') }}</a>
                @endif
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                    <tr>
                        <th>{{ translateKeyword('id') }}</th>
                        <th>{{ translateKeyword('document_name') }}</th>
                        <th>{{ translateKeyword('type') }}</th>
                        <th>{{ translateKeyword('expiry-required') }}</th>
                        <th>{{ translateKeyword('action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($documents as $index => $document)
                    @php
                        $name = $document->translations->where('language_id', session('translation'))->first()->name ?? $document->name;
                    @endphp
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$name}}</td>
                            <td>{{$document->type}}</td>
                            <td>{{$document->expiry_required}}</td>
                            <td>
                                <form action="{{ route('admin.document.destroy', $document->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    @if ($edit_permission == 1)
                                    <a href="{{ route('admin.document.edit', $document->id) }}" class="btn btn-info"><i
                                                class="fa fa-edit"></i> {{ translateKeyword('edit') }}</a>
                                    @endif
                                    @if ($delete_permission == 1)
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i
                                                class="fa fa-trash"></i> {{ translateKeyword('delete') }}
                                    </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>{{ translateKeyword('id') }}</th>
                        <th>{{ translateKeyword('document_name') }}</th>
                        <th>{{ translateKeyword('type') }}</th>
                        <th>{{ translateKeyword('expiry-required') }}</th>
                        <th>{{ translateKeyword('action') }}</th>
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