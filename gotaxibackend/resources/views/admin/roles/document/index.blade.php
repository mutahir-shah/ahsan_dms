@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'User Documents ')

@section('content')

    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <div class="content-wrapper">
        <div class="container-fluid">
            {{-- <div class="card">
                <div class="card-header mb-10">
                    <div class="row"> <div class="col"> <a href="{{ route('admin.provider.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a> </div> </div>
                        
                </div>
            </div>     --}}
            
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active in" id="driver"
                    role="tabpanel" aria-labelledby="driver-tab">
                    <div class="box box-block bg-white border-radius-10">
                        <h4 class="col-12">{{ translateKeyword('User Documents')}}</h4>
                        <div class="row">
                            <div class="col-xs-12">
                                <fieldset>
                                    <form action="{{ route('admin.user_documents.store', $user->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        <h5>{{ translateKeyword('create-new')}}</h5>
                                        {{ csrf_field() }}
                                        <div class="col-xs-3">
                                            <select class="form-control input" name="document_id"
                                                data-expiry-input-id="provider_expiry_date" data-document-id required>
                                                <option selected disabled value="">{{ translateKeyword('Please select document')}}</option>
                                                @forelse($UserDocuments as $Document)
                                                    <option value="{{ $Document->id }}"
                                                        data-required="{{ $Document->expiry_required }}">
                                                        {{ $Document->name }}</option>
                                                @empty
                                                    <option disabled>- {{ translateKeyword('Please Create a Document')}} -</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-xs-3">
                                            <input class="form-control" type="date" name="expiry_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                id="provider_expiry_date" style="visibility: hidden" />
                                        </div>

                                        <div class="col-xs-3">
                                            <input type="file" name="document" required
                                                accept="application/pdf, image/*">
                                        </div>
                                        <div class="col-xs-3">
                                            <button class="btn btn-primary btn-block" type="submit">{{ translateKeyword('add')}}</button>
                                        </div>
                                    </form>
                                </fieldset>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="table-1" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ translateKeyword('document_type')}}</th>
                                                    <th>{{ translateKeyword('Expiry')}} </th>
                                                    <th>{{ translateKeyword('status')}}</th>
                                                    <th>{{ translateKeyword('action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($UserDocumentsData as $Index => $Document)
                                                    @php
                                                        $now = \Carbon\Carbon::now();
                                                        $expiry_days_left = $now->diffInDays($Document->expiry_date, false);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $Index + 1 }}</td>
                                                        <td>{{ $Document->document->name }}</td>
                                                        <td> <b>{{ translateKeyword('Required')}}: </b> {{ $Document->document->expiry_required }}
                                                            <br />
                                                            <b>{{ translateKeyword('Date')}}:
                                                            </b>{{ $Document->expiry_date ? $Document->expiry_date->toFormattedDateString() : 'N/A' }}
                                                            <br />
                                                            <b>{{ translateKeyword('Day(s) Left')}}:</b> {{ $expiry_days_left }}
                                                        </td>
                                                        <td>{{ $Document->status }}</td>
                                                        <td>
                                                            <div class="input-group-btn">
                                                                <form
                                                                    action="{{ route('admin.user_documents.destroy', [$user->id, $Document->id]) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Are you sure?');">
                                                                    <a
                                                                        href="{{ route('admin.user_documents.edit', [$user->id, $Document->id]) }}"><span
                                                                            class="btn btn-success btn-large">{{ translateKeyword('View')}}</span></a>
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button class="btn btn-danger btn-large">{{ translateKeyword('delete')}}
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    th>#</th>
                                                    <th>{{ translateKeyword('document_type')}}</th>
                                                    <th>{{ translateKeyword('Expiry')}} </th>
                                                    <th>{{ translateKeyword('status')}}</th>
                                                    <th>{{ translateKeyword('action')}}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', _ => {
            const documentIdSelectElems = document.querySelectorAll('[data-document-id]');

            documentIdSelectElems.forEach(select => {
                const expiryInput = document.querySelector(
                    `#${select.getAttribute('data-expiry-input-id')}`);
                const updateExpiryRequired = () => {
                    const isExpiryRequired = select.options[select.selectedIndex].getAttribute(
                        'data-required') === 'YES';
                    expiryInput.style.visibility = isExpiryRequired ? 'initial' : 'hidden';
                    isExpiryRequired ? expiryInput.setAttribute('required', 'true') : expiryInput
                        .removeAttribute('required');
                };

                select.addEventListener('change', updateExpiryRequired);
                updateExpiryRequired();
            });
        });
    </script>
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
@endsection
