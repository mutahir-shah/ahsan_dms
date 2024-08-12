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
                            <h3 class="card-title">{{ $defaultLanguage->name }} {{ translateKeyword('keywords')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="overflow: scroll;">
                            <form action="{{ route('admin.language.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="language_id" value="{{ $defaultLanguage->id }}">
                                <table id="table-1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">{{ translateKeyword('id') }}</th>
                                            <th width="40%">{{ translateKeyword('name') }}</th>
                                            <th>{{ translateKeyword('translations')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($defaultLanguage->keywords as $i => $keyword)
                                            @php
                                                $otherLanguage = getTranslationByLanguageId($id, $keyword->id);
                                            @endphp
                                            @if ($otherLanguage)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $keyword->translation }}</td>
                                                    <td>
                                                        <input type="hidden" name="translation_id" value="{{ $otherLanguage->id }}">
                                                        <input type="text" 
                                                            class="form-control translation-input"
                                                            name="translations"
                                                            value="{{ $otherLanguage->translation }}"
                                                        />
                                                    </td>
                                                </tr>
                                            @endif
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

            $('.translation-input').on('keyup', function(event) {
    // Check if the Enter key (key code 13) is pressed
    if (event.keyCode === 13) {
        const input = $(this);
        const translation = $(this).val();
        const id = $(this).parent().find('input[name="translation_id"]').val();
        const token = '{{ csrf_token() }}';

        if(!$.trim(translation)){
            input.focus();
            return toastr.error("{{ translateKeyword('translation_should_not_be_empty') }}");
        }

        $.ajax({
            url: "{{ route('admin.language.update-translation') }}",
            method: "POST",
            data: {
                _token: token,
                id: id,
                translation: translation,
            },
            success: function(response) {
                toastr.success("{{ translateKeyword('translation_saved_successfully') }}");
            },
            error: function(xhr, status, error) {
                console.error('Error saving translation:', error);
            }
        });
    }
});

        });
    </script>
@endsection
