@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Language Keywords')

@section('content')

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card border-radius-10">
                        <div class="card-header">
                            @include('common.notify')
                            <h3 class="card-title">{{ $language->name }} {{ translateKeyword('keywords')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="overflow: scroll;">
                            <form action="{{ route('admin.language.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="language_id" value="{{ $language->id }}">
                                <table id="table-1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ translateKeyword('id') }}</th>
                                            <th>{{ translateKeyword('name') }}</th>
                                            <th>{{ translateKeyword('translations')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($keywords as $i => $keyword)
                                            @php
                                                $existingTranslation = $language->keywords->firstWhere(
                                                    'id',
                                                    $keyword->id,
                                                );
                                            @endphp
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $keyword->name }}</td>
                                                <td>
                                                    <input type="hidden" name="keyword_ids[]" value="{{ $keyword->id }}">
                                                    <input type="text" class="form-control translation-input"
                                                        name="translations[]"
                                                        value="{{ $existingTranslation ? $existingTranslation->pivot->translation : '' }}"
                                                        data-keyword-id="{{ $keyword->id }}"
                                                        id="translation-{{ $keyword->id }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>{{ translateKeyword('id') }}</th>
                                            <th>{{ translateKeyword('name') }}</th>
                                            <th>{{ translateKeyword('translations')}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        $(document).ready(function() {

            $('.translation-input').on('blur', function() {
                var $input = $(this);
                var keywordId = $input.data('keyword-id');
                var translation = $input.val();
                var languageId = $('input[name="language_id"]').val();
                var token = '{{ csrf_token() }}';

                $.ajax({
                    url: '{{ route('admin.language.store') }}',
                    method: 'POST',
                    data: {
                        _token: token,
                        language_id: languageId,
                        keyword_id: keywordId,
                        translation: translation
                    },
                    success: function(response) {
                        console.log(response);
                        toastr.success('Translation saved successfully.');
                        $input.closest('tr').remove();

                        if ($('.translation-input').length === 0) {
                            // Redirect to a specific route
                            window.location.href = '{{ route('admin.language.index') }}';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving translation:', error);
                    }
                });
            });
        });
    </script>
@endsection
