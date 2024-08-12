@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Blogs ')

@section('content')

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            @include('common.notify')
                            <h3 class="card-title">{{ translateKeyword('blogs') }}</h3>
                            <a href="{{ route('admin.blogs.create') }}"
                                class="btn btn-primary pull-right">{{ translateKeyword('create-new') }}</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="overflow: scroll;">
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ translateKeyword('Service_Image') }}</th>
                                        <th>{{ translateKeyword('title') }}</th>
                                        <th>{{ translateKeyword('is_featured') }}</th>
                                        <th>{{ translateKeyword('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $key => $blog)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $blog->image) }}" style="height: 50px">
                                            </td>
                                            <td>
                                                @php
                                                    // Find the translation for the current session language
                                                    $translation = $blog->translations->firstWhere('language_id', session('translation'));
                                            
                                                    // If no translation is found for the session language, get the first available translation
                                                    if (!$translation) {
                                                        $translation = $blog->translations->first();
                                                    }
                                                @endphp
                                            
                                                @if ($translation)
                                                    {{ $translation->title }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($blog->is_featured == 1)
                                                    {{ translateKeyword('featured') }}
                                                @else
                                                    <a href="{{ route('admin.blogs.make-featured', $blog->id) }}"
                                                        class="btn btn-sm btn-primary">{{ translateKeyword('make-featured') }}</a>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}"
                                                    method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                                        class="btn btn-info">

                                                        <i class="fa fa-edit"></i> {{ translateKeyword('edit') }}

                                                    </a>
                                                    <button class="btn shadow-box btn-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-trash"></i> {{ translateKeyword('delete') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ translateKeyword('Service_Image') }}</th>
                                        <th>{{ translateKeyword('title') }}</th>
                                        <th>{{ translateKeyword('is_featured') }}</th>
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



        <!-- DataTables -->
        <script src="{{ asset('admin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('admin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{ asset('admin') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{ asset('admin') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    </div>
@endsection
