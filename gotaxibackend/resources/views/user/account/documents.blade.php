@extends('user.layout.base')

@section('title', 'Manage Documents ')

@section('content')
    <div class="page-content">
        <div class="container">
            <a href="{{ route('user.profile') }}" class="pro-head-link">{{ translateKeyword('profile')}}</a>
            <a href="{{ route('user.documents') }}" class="pro-head-link active">{{ translateKeyword('Manage Documents')}}</a>
        </div>
    </div>

    <div class="pro-dashboard-content gray-bg">
        <div class="container">
            <div class="manage-docs ">
                <div class="manage-doc-content">
                    <div class="manage-doc-section pad50">
                        <div class="manage-doc-section-head row no-margin">
                            <h3 class="manage-doc-tit">
                                {{ translateKeyword('Users Documents')}}
                            </h3>
                        </div>

                        <div>
                            @foreach ($UserDocuments as $Document)
                                <div class="manage-doc-box row no-margin border-top">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="manage-doc-box-left">
                                            <p class="manage-txt">
                                                @php
                                                    $document_url = isset($user->document($Document->id)->url) ? $user->document($Document->id)->url : '#';
                                                    $show_expiry = $Document->expiry_required == 'YES';
                                                    if (isset($user->document($Document->id)->expiry_date)) {
                                                        $now = \Carbon\Carbon::now()->startOfDay();
                                                        $expiry_date = \Carbon\Carbon::parse($user->document($Document->id)->expiry_date);
                                                        $daysLeft = $now->diffInDays($expiry_date, false);
                                                        $isExpired = $daysLeft < 0 ;
                                                        $statusClass = $isExpired ? 'text-danger' : '';
                                                        $expiry_date = $expiry_date->format('d-m-Y');
                                                        $statusText = $isExpired ? 'Expired' : $daysLeft . ' days left';
                                                    } else {
                                                        $statusClass = '';
                                                        $statusText = '';
                                                        $expiry_date = 'N/A';
                                                    }
                                                @endphp
                                                <a href="{{ $document_url }}" target="_blank">
                                                    <img src="{{ $document_url }}"
                                                        onerror="this.src = '{{ asset('/asset/img/document_placeholder.png') }}';"
                                                        class="document_thumbnail" />
                                                </a>
                                                {{ $Document->name }}
                                            </p>
                                            <p class="license">
                                                @if ($show_expiry)
                                                    Expires: {{ $expiry_date }}
                                                    <span class="{{ $statusClass }}"
                                                        style="display: block">{{ $statusText }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="manage-doc-box-center text-center">
                                            <p
                                                class="manage-badge {{ $user->document($Document->id) ? ($user->document($Document->id)->status == 'ASSESSING' ? 'yellow-badge' : 'green-badge') : 'red-badge' }}">
                                                {{ $user->document($Document->id) ? $user->document($Document->id)->status : 'MISSING' }}
                                            </p>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 vertical-align-sm">
                                        <button data-toggle="modal"
                                            data-target="#upload_document_modal-{{ $Document->id }}"
                                            class="manage-doc-upload-btn"> <i class="fa fa-upload upload-icon "></i>
                                            {{ translateKeyword('Upload')}}</button>
                                    </div>
                                    <div id="upload_document_modal-{{ $Document->id }}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">{{ translateKeyword('Upload Document')}}</h4>
                                                </div>
                                                <form action="{{ route('user.documents.update', $Document->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PUT') }}
                                                        <div class="form-group">
                                                            <label for="document" class="form-label">{{ translateKeyword('document')}}</label>
                                                            <input type="file" id="document" class="form-control"
                                                                name="document" required accept="application/pdf, image/*">
                                                        </div>

                                                        @if ($show_expiry)
                                                            <div class="form-group">
                                                                <label for="document" class="form-label">{{ translateKeyword('expiry-date')}}</label>
                                                                <input class="form-control" required
                                                                    min="{{ date('Y-m-d') }}" type="date"
                                                                    name="expires_at" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="submit">{{ translateKeyword('Upload')}}</button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>
@endsection

@section('styles')
    <link href="{{ asset('asset/css/jasny-bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <style type="text/css">
        .fileinput .btn-file {
            padding: 0;
            background-color: #fff;
            border: 0;
            border-radius: 0 !important;
        }

        .fileinput .form-control {
            border: 0;
            box-shadow: none;
            border-left: 0;
            border-right: 5px;
        }

        .fileinput .upload-link {
            border: 0;
            border-radius: 0;
            padding: 0;
        }

        .input-group-addon.btn {
            background: #fff;
            border: 1px solid #37b38b;
            border-radius: 0;
            padding: 10px;
            height: 40px;
            line-height: 20px;
        }

        .fileinput .fileinput-filename {
            font-size: 10px;
        }

        .fileinput .btn-submit {
            padding: 0;
        }

        .fileinput button {
            background-color: white;
            border: 0;
            padding: 10px;
        }
    </style>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('asset/js/jasny-bootstrap.min.js') }}"></script>
@endsection
