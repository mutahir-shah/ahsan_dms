@extends('provider.layout.app')

@section('content')
    <div class="pro-dashboard-head">
        <div class="container">
            <a href="{{ route('provider.profile.index') }}" class="pro-head-link">Profile</a>
            <a href="#" class="pro-head-link active">Manage Documents</a>
            <a href="{{ route('provider.location.index') }}" class="pro-head-link">Update Location</a>
        </div>
    </div>

    <div class="pro-dashboard-content gray-bg">
        <div class="container">
            <div class="manage-docs pad30">
                <div class="manage-doc-content">
                    <div class="manage-doc-section pad50">
                        <div class="manage-doc-section-head row no-margin">
                            <h3 class="manage-doc-tit">
                                Provider's Documents
                            </h3>
                        </div>

                        <div class="manage-doc-section-content">
                            @foreach ($DriverDocuments as $Document)
                                <div class="manage-doc-box row no-margin border-top">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="manage-doc-box-left">
                                            <p class="manage-txt">
                                                @php
                                                    $document_url = isset($provider->document($Document->id)->url) ? 'storage/' . $provider->document($Document->id)->url : '#';
                                                    $show_expiry = $Document->expiry_required == 'YES';
                                                    if (isset($provider->document($Document->id)->expires_at)) {
                                                        $now = \Carbon\Carbon::now();
                                                        $expiry_date = \Carbon\Carbon::parse($provider->document($Document->id)->expires_at)->format('d-m-Y');
                                                        $isExpired = $now->gte($expiry_date);
                                                        $statusClass = $isExpired ? 'text-danger' : '';
                                                        $daysLeft = $now->diffInDays($expiry_date);
                                                        $statusText = $isExpired ? 'Expired' : $daysLeft . ' days left';
                                                    } else {
                                                        $statusClass = '';
                                                        $statusText = '';
                                                        $expiry_date = 'N/A';
                                                    }
                                                @endphp
                                                <a href="{{ asset($document_url) }}" target="_blank">
                                                    <img src="{{ asset($document_url) }}"
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
                                                class="manage-badge {{ $provider->document($Document->id) ? ($provider->document($Document->id)->status == 'ASSESSING' ? 'yellow-badge' : 'green-badge') : 'red-badge' }}">
                                                {{ $provider->document($Document->id) ? $provider->document($Document->id)->status : 'MISSING' }}
                                            </p>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 vertical-align-sm">
                                        <button data-toggle="modal"
                                            data-target="#upload_document_modal-{{ $Document->id }}"
                                            class="manage-doc-upload-btn"> <i class="fa fa-upload upload-icon "></i>
                                            Upload</button>
                                    </div>
                                    <div id="upload_document_modal-{{ $Document->id }}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Upload Document</h4>
                                                </div>
                                                <form action="{{ route('provider.documents.update', $Document->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH') }}
                                                        <div class="form-group">
                                                            <label for="document" class="form-label">Document</label>
                                                            <input type="file" id="document" class="form-control"
                                                                name="document" required accept="application/pdf, image/*">
                                                        </div>

                                                        @if ($show_expiry)
                                                            <div class="form-group">
                                                                <label for="document" class="form-label">Expiry Date</label>
                                                                <input class="form-control" required
                                                                    min="{{ date('Y-m-d') }}" type="date"
                                                                    name="expires_at" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="submit">Upload</button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="manage-doc-section">
                    <div class="manage-doc-section-head row no-margin">
                        <h3 class="manage-doc-tit">
                            Vehicle's Documents
                        </h3>
                    </div>

                    <div class="manage-doc-section-content">
                        <div class="container">
                            <ul class="nav nav-tabs" id="myTabs">
                                @foreach ($VehicleDocuments as $vehicle => $documents)
                                    <li class="{{ $loop->first ? 'active' : '' }}"><a data-toggle="tab"
                                            href="#{{ str_replace(' ', '_', $vehicle) }}"> {{ $vehicle }} </a></li>
                                @endforeach
                            </ul>

                            <div class="tab-content">
                                @foreach ($VehicleDocuments as $vehicle => $documents)
                                    <div id="{{ str_replace(' ', '_', $vehicle) }}"
                                        class="tab-pane fade in {{ $loop->first ? 'active' : '' }}">
                                        {{-- Content here. --}}

                                        @foreach ($documents as $document)
                                            <div class="manage-doc-box row no-margin border-top ">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="manage-doc-box-left">
                                                        <p class="manage-txt">
                                                            @php
                                                                $document_url = isset($document->url) ? 'storage/' . $document->url : '#';
                                                                $show_expiry = $document->document->expiry_required == 'YES';
                                                                if (isset($document->expires_at)) {
                                                                    $expiry_date = \Carbon\Carbon::parse($document->expires_at)->format('d-m-Y');
                                                                    $now = \Carbon\Carbon::now();
                                                                    $isExpired = $now->gte($expiry_date);
                                                                    $statusClass = $isExpired ? 'text-danger' : '';
                                                                    $daysLeft = $now->diffInDays($expiry_date);
                                                                    $statusText = $isExpired ? 'Expired' : $daysLeft . ' days left';
                                                                } else {
                                                                    $statusClass = '';
                                                                    $statusText = '';
                                                                    $expiry_date = 'N/A';
                                                                }
                                                            @endphp
                                                            <a href="{{ asset($document_url) }}" target="_blank">
                                                                <img src="{{ asset($document_url) }}"
                                                                    onerror="this.src = '{{ asset('/asset/img/document_placeholder.png') }}';"
                                                                    class="document_thumbnail" />
                                                            </a>
                                                            {{ $document->name }}
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
                                                            class="manage-badge {{ $document ? ($document->status == 'ASSESSING' ? 'yellow-badge' : 'green-badge') : 'red-badge' }}">
                                                            {{ $document ? $document->status : 'MISSING' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div id="upload_vehicle_document_modal-{{ $document->id }}"
                                                    class="modal fade " role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Upload Document</h4>
                                                            </div>
                                                            <form
                                                                action="{{ route('provider.documents.update', $document->document_id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('PATCH') }}
                                                                    <div class="form-group">
                                                                        <label for="document"
                                                                            class="form-label">Document</label>
                                                                        <input type="file" id="document"
                                                                            class="form-control" name="document" required
                                                                            accept="application/pdf, image/*">
                                                                    </div>
                                                                    <input type="hidden"
                                                                        value="{{ $document->vehicle_id }}"
                                                                        name="vehicle" />

                                                                    @if ($show_expiry)
                                                                        <div class="form-group">
                                                                            <label for="document"
                                                                                class="form-label">Expiry
                                                                                Date</label>
                                                                            <input class="form-control" type="date"
                                                                                min="{{ date('Y-m-d') }}" required
                                                                                name="expires_at" />
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary"
                                                                        type="submit">Upload</button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <button data-toggle="modal"
                                                    data-target="#upload_vehicle_document_modal-{{ $document->id }}"
                                                    class="manage-doc-upload-btn"> <i
                                                        class="fa fa-upload upload-icon"></i>
                                                    Upload</button>
                                            </div>
                                    </div>
                                @endforeach




                            </div>
                            @endforeach
                        </div>
                    </div>
                    @foreach ($VehicleDocuments as $Document)
                        {{-- <div class="manage-doc-box row no-margin border-top ">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="manage-doc-box-left">
                                        <p class="manage-txt">
                                            @php
                                                $document = $provider->document($Document->id);
                                                $document_url = isset($document->url) ? 'storage/' . $document->url : '#';
                                                $show_expiry = $Document->expiry_required == 'YES';
                                                if (isset($document->expires_at)) {
                                                    $expiry_date = \Carbon\Carbon::parse($document->expires_at)->format('d-m-Y');
                                                    $now = \Carbon\Carbon::now();
                                                    $isExpired = $now->gte($expiry_date);
                                                    $statusClass = $isExpired ? 'text-danger' : '';
                                                    $daysLeft = $now->diffInDays($expiry_date);
                                                    $statusText = $isExpired ? 'Expired' : $daysLeft . ' days left';
                                                } else {
                                                    $statusClass = '';
                                                    $statusText = '';
                                                    $expiry_date = 'N/A';
                                                }
                                            @endphp
                                            <a href="{{ asset($document_url) }}" target="_blank">
                                                <img src="{{ asset($document_url) }}"
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
                                            class="manage-badge {{ $document ? ($document->status == 'ASSESSING' ? 'yellow-badge' : 'green-badge') : 'red-badge' }}">
                                            {{ $document ? $document->status : 'MISSING' }}
                                        </p>
                                    </div>
                                </div>
                                <div id="upload_vehicle_document_modal-{{ $Document->id }}" class="modal fade "
                                    role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Upload Document</h4>
                                            </div>
                                            <form action="{{ route('provider.documents.update', $Document->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PATCH') }}
                                                    <div class="form-group">
                                                        <label for="document" class="form-label">Document</label>
                                                        <input type="file" id="document" class="form-control"
                                                            name="document" required accept="application/pdf, image/*">
                                                    </div>

                                                    @if ($show_expiry)
                                                        <div class="form-group">
                                                            <label for="document" class="form-label">Expiry Date</label>
                                                            <input class="form-control" type="date"
                                                                min="{{ date('Y-m-d') }}" required name="expires_at" />
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="submit">Upload</button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <button data-toggle="modal"
                                    data-target="#upload_vehicle_document_modal-{{ $Document->id }}"
                                    class="manage-doc-upload-btn"> <i class="fa fa-upload upload-icon"></i>
                                    Upload</button>
                            </div>
                        </div> --}}
                    @endforeach
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
